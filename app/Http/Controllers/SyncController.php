<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Support\Str;
use Elasticsearch;
use App\Models\Jobs;
use App\Models\JobsQuestion;
use App\Models\JobsAnswer;
use App\Models\Country;
use App\Models\City;
use \Greenhouse\GreenhouseToolsPhp\GreenhouseService;
use Notification;



class SyncController extends Controller
{

    static $flag = array("cn");


    public function generateSearchIndex()
    {
        // try deleting the index (if exists)
        try {
            // remove index
            Elasticsearch::indices()->delete([
                'index' =>  'booking',
            ]);
        }
        catch (Missing404Exception $e) {
            echo "error 404";
            exit;
        }

        // create index
        Elasticsearch::indices()->create([
            'index' =>  'booking',
        ]);

        // set mappings before adding any data
        Jobs::putMappings();

        // Import jobs data to index
        Jobs::addAllToIndex([
            'field'     =>  'status',
            'operator'  =>  '=',
            'value'     => 1
        ]);

        //Jobs::addAllToIndex();


        //Notification::success('The search index has been successfully rebuilt');

    }

/*
    public function syncGreenhouseJobsByHarvest()
    {


        //Greenhouse API Connaction
        $greenhouseService = new GreenhouseService([
            'apiKey' => config('greenhouse.api_key'),
            'boardToken' => config('greenhouse.client_token')
        ]);
        $harvestService = $greenhouseService->getHarvestService();
        $apiService = $greenhouseService->getJobApiService();

        // Get jobs testing
        // $params = array('page' => 10, 'per_page' => 100);
        // $job_posts_json = $harvestService->getJobs($params);
        // $job_posts_array = json_decode($job_posts_json);
        // var_dump($job_posts_array);exit;


        $data_array = array();  //Availability Job Array
        $job_id_array = array();    //Jobs id Array
        $page = 23;     //Jobs page number
        $job_count = 1; //Loop Condition
        $updated_after = "";    //Query Condition


        while ($job_count>0) {

            //Get Job List
            $params = array('page' => $page, 'per_page' => 250);
            $jobs_json = $harvestService->getJobs($params);
            $jobs_array = json_decode($jobs_json);
            $job_count = count($jobs_array);

            if ($job_count > 0) {

                foreach ($jobs_array as $value) {

                    if($value->custom_fields->internal_job_only == TRUE){

                        if($value->status == "open"){

                            //Get Job location
                            if(!empty($value->offices[0]->location->name)){

                                $location_array = explode(",", $value->offices[0]->location->name);
                                $data_array[$value->id]["country"] = (isset($location_array[1])) ? strtolower(trim($location_array[1])) : "";
                                $data_array[$value->id]["city"] = (isset($location_array[0])) ? strtolower(trim($location_array[0])) : "";

                            }else{
                                $data_array[$value->id]["country"] = "";
                                $data_array[$value->id]["city"] = "";
                            }

                            if($data_array[$value->id]["country"] == "china"){

                                $job_id_array[] = $value->id;
                                $data_array[$value->id]["requisition_id"] = $value->requisition_id;
                                $data_array[$value->id]["department"] = $value->departments[0]->name;
                                $data_array[$value->id]["entity"] = $value->keyed_custom_fields->legal_entity->value;

                                $data_array[$value->id]["status"] = $value->status;
                            }

                        }else{

                            //Close job in the local DB
                            Jobs::where('job_id',$value->id)->update(['status'=> 0]);

                        }

                    }

                }

            }

            $page++;

        }



        foreach ($job_id_array as $id) {

            $params = array('id'=>$id);
            $job_posts_json = $harvestService->getJobPostForJob($params);
            $job_posts = json_decode($job_posts_json);


            if(count($job_posts) > 0){


                foreach ($job_posts as $post) {

                    $job = Jobs::where('post_id', $post->id)->first();
                    if (empty($job)) {

                        if($post->live == true){

                            //Get Country&City from location
                            if(empty($data_array[$post->job_id]["city"]) && !empty($post->location->name)){

                                $location_array = explode(",", $post->location->name);
                                $data_array[$post->job_id]["country"] = (isset($location_array[1])) ? strtolower(trim($location_array[1])) : "";
                                $data_array[$post->job_id]["city"] = (isset($location_array[0])) ? strtolower(trim($location_array[0])) : "";                                
                            }

                            //Get Flag name from country
                            if (!empty($data_array[$post->job_id]["country"])) {
                                $country = Country::where('country',$data_array[$post->job_id]["country"])->first();
                                if (!empty($country)) {
                                    $flag = $country->short;
                                }else{
                                    $flag = "";
                                }
                            }else{
                                $flag = "";
                            }


                            if($flag != ""){

                                //Insert record
                                $job_data["requisition_id"] = $data_array[$post->job_id]["requisition_id"];;
                                $job_data["post_id"] = $post->id;
                                $job_data["job_id"] = $post->job_id;
                                $job_data["title"] = $post->title;
                                $job_data["slug"] = Str::slugutf8($post->title);
                                $job_data["location"] = $post->location->name;
                                $job_data["department"] = $data_array[$post->job_id]["department"];
                                $job_data["country"] = $data_array[$post->job_id]["country"];
                                $job_data["city"] = $data_array[$post->job_id]["city"];
                                $job_data["flag"] = $flag;
                                $job_data["entity"] = $data_array[$post->job_id]["entity"];
                                $description = (!empty($post->content)) ? $post->content : $post->internal_content;
                                $job_data["description"] = filter_html_tag($description);
                                $job_data["job_created_at"] = $post->created_at;
                                $job_data["job_updated_at"] = $post->updated_at;
                                $job_data["internal"] = $post->internal;
                                $job_data["status"] = 1;
                                $j = Jobs::create($job_data);
                                $job_post_id = $j->id;


                                //Insert to city library table
                                City::firstOrCreate(array('city' => $data_array[$post->job_id]["city"]));
                                City::where('city',$data_array[$post->job_id]["city"])->where('city_cn',NULL)->update(array('country' =>$flag, 'city_cn' => $data_array[$post->job_id]["city"]));


                                //if(!empty($job_post_id)) $this->syncQuestionToDB($post->job_id,$job_post_id);

                            }

                        }    

                    }else{

                        if ($job->job_updated_at != $post->updated_at) {


                            //Get Flag name from country
                            if (!empty($data_array[$post->job_id]["country"])) {
                                $country = Country::where('country',$data_array[$post->job_id]["country"])->first();
                                if (!empty($country)) {
                                    $flag = $country->short;
                                }else{
                                    $flag = "";
                                }
                            }else{
                                $flag = "";
                            }

                            if($flag != ""){
                                // $job->requisition_id = $data_array[$post->job_id]["requisition_id"];;
                                // $job->post_id = $post->id;
                                // $job->job_id = $post->job_id;
                                $job->title = $post->title;
                                $job->slug = Str::slugutf8($post->title);
                                $job->location = $post->location->name;
                                $job->department = $data_array[$post->job_id]["department"];
                                $job->country = $data_array[$post->job_id]["country"];
                                $job->city = $data_array[$post->job_id]["city"];
                                $job->flag = $flag;
                                $job->entity = $data_array[$post->job_id]["entity"];
                                $job->description = (!empty($post->content)) ? $post->content : $post->internal_content;
                                $job->job_created_at = $post->created_at;
                                $job->job_updated_at = $post->updated_at;
                                $job->internal = $post->internal;
                                $job->status = ($post->live) ? 1 : 0;
                                $job->update();

                            }
                            
                        }

                    }

                }    

            }

        }


        $this->generateSearchIndex();

    }

*/
    public function syncGreenhouseJobsByJobboard(){


        $greenhouseService = new GreenhouseService([
            'apiKey' => config('greenhouse.api_key_jobboard'),
            'boardToken' => config('greenhouse.client_token')
        ]);

        $apiService = $greenhouseService->getJobApiService();
        
        $jobs_json = $apiService->getJobs(true);
        $jobs_array = json_decode($jobs_json);
        $job_count = count($jobs_array->jobs);
        $is_rebuild = FALSE;

        if ($job_count>0) {

            foreach ($jobs_array->jobs as $post) {
                // var_dump($jobs_array);exit;
                //Get Job location
                if(!empty($post->offices[0]->name)){

                    $location_array = explode(",", $post->offices[0]->name);
                    $country = (isset($location_array[1])) ? strtolower(trim($location_array[1])) : "";
                    $city = (isset($location_array[0])) ? strtolower(trim($location_array[0])) : "";
                    $city_cn = (!empty($city)) ? trans('messages.cities.'.$city) : "";

                }else{
                    $country = "";
                    $city = "";
                    $city_cn = "";
                }


                //Get Flag name from country
                if (!empty($country)) {
                    $country_obj = Country::where('country',$country)->first();
                    if (!empty($country_obj)) {
                        $flag = $country_obj->short;
                    }else{
                        $flag = "";
                    }
                }else{
                    $flag = "";
                }


                foreach ($post->metadata as $value) {
                    switch ($value->name) {
                        case 'Job Visibility':
                            $visibility = $value->value;
                            break;
                        case 'Booking.com entity':
                            $entity = $value->value;
                            break;
                        case 'Assigned Region':
                            $region = $value->value;
                            break;
                        case 'Business Owner':
                            $owner = $value->value;
                            break;
                        case 'Language':
                            $language = (is_array($value->value)) ? implode($value->value, ',') : $value->value;
                            break;
                        case 'Type of CSE':
                            $cse = $value->value;
                            break;
                        
                        default:
                            break;
                    }
                }

                //Insert into AND Update jobs to DB, job visibility is microsite
                if(strtolower($visibility) == "microsite" && in_array($flag, SELF::$flag)){

                    $job = Jobs::where('post_id', $post->id)->first();
                    if (empty($job)) {

                            //Insert record
                            // $job_data["requisition_id"] = $data_array[$post->job_id]["requisition_id"];;
                            $job_data["post_id"] = $post->id;
                            $job_data["job_id"] = $post->internal_job_id;
                            $job_data["title"] = $post->title;
                            $job_data["slug"] = Str::slugutf8($post->title);
                            $job_data["location"] = $post->location->name;
                            $job_data["department"] = (!empty($post->departments[0]->name)) ? $post->departments[0]->name : null;
                            $job_data["country"] = $country;
                            $job_data["city"] = $city;
                            $job_data["flag"] = $flag;
                            $job_data["entity"] = $entity;
                            $job_data["region"] = $region;
                            $job_data["owner"] = $owner;
                            $job_data["language"] = $language;
                            $job_data["cse"] = $cse;
                            $job_data["description"] = filter_html_tag($post->content);
                            $job_data["job_updated_at"] = $post->updated_at;
                            $job_data["internal"] = 1;
                            $job_data["status"] = 1;
                            $j = Jobs::create($job_data);
                            $job_post_id = $j->id;


                            //Insert to city of library table
                            City::firstOrCreate(array('city' => $city));
                            City::where('city',$city)->where('city_cn',NULL)->update(array('country' =>$flag, 'city_cn' => $city_cn));


                            if(!empty($job_post_id)){

                                /***Get Job Posts&Sync to DB&Elasticsearch***/
                                //$question_exclude_array = array("first name","last name","email","phone","resume","resume_text","cover_letter","cover_letter_text","harver_pass","harver_test_result");
                                $is_rebuild = TRUE;
                                $job_post_single = $apiService->getJob($post->id,true);
                                $post_detail = json_decode($job_post_single);

                                foreach ($post_detail->questions as $question) {

                                    if (substr($question->fields[0]->name, 0, 8) == "question") {

                                        $question_data['parent_id'] = $job_post_id;
                                        $question_data['post_id'] = $post->id;
                                        $question_data['type'] = $question->fields[0]->type;
                                        $question_data['question'] = $question->label;
                                        $question_data['is_required'] = $question->required;
                                        $question_data['name'] = $question->fields[0]->name;
                                        $q = JobsQuestion::create($question_data);
                                        $question_id = $q->id;

                                        if($question->fields[0]->type == "multi_value_multi_select" || $question->fields[0]->type == "multi_value_single_select"){

                                            if ($question->fields[0]->type == "multi_value_single_select" && ($question->fields[0]->values[0]->value == 0 || $question->fields[0]->values[0]->value == 1)) {
                                                
                                                JobsQuestion::where('id',$question_id)->update(['type'=> 'boolean']);
                                            }else{

                                                foreach ($question->fields[0]->values as $answer) {

                                                    $job_question = new JobsAnswer();
                                                    $job_question->question_id = $question_id;
                                                    $job_question->answer = $answer->value;
                                                    $job_question->label = $answer->label;
                                                    $job_question->save();

                                                }
                                            }

                                        }

                                    }

                                    if ($question->label == 'Cover Letter' && $question->required == true) {
                                        
                                        Jobs::where('id',$job_post_id)->update(['is_required_coverletter'=> 1]);

                                    }

                                    if ($question->label == 'Resume' && $question->required == true) {
                                        
                                        Jobs::where('id',$job_post_id)->update(['is_required_resume'=> 1]);

                                    }

                                }

                            }


                    }else{


                        if ($job->job_updated_at != $post->updated_at) {

                                $job->title = $post->title;
                                $job->slug = Str::slugutf8($post->title);
                                $job->location = $post->location->name;
                                $job->department = (!empty($post->departments[0]->name)) ? $post->departments[0]->name : null;
                                $job->country = $country;
                                $job->city = $city;
                                $job->flag = $flag;
                                $job->entity = $entity;
                                $job->region = $region;
                                $job->owner = $owner;
                                $job->language = $language;
                                $job->cse = $cse;
                                $job->description = filter_html_tag($post->content);
                                $job->job_updated_at = $post->updated_at;
                                $job->update();


                                JobsQuestion::where('parent_id',$job->id)->update(['status'=> 0]);

                                $is_rebuild = TRUE;
                                $job_post_id = $job->id;
                                $job_post_single = $apiService->getJob($post->id,true);
                                $post_detail = json_decode($job_post_single);

                                foreach ($post_detail->questions as $question) {


                                    if (substr($question->fields[0]->name, 0, 8) == "question") {

                                        $question_db = JobsQuestion::Where('post_id', $job->post_id)->Where('name', $question->fields[0]->name)->first(); 

                                        if (empty($question_db)) {

                                            $question_data['parent_id'] = $job->id;
                                            $question_data['post_id'] = $job->post_id;
                                            $question_data['type'] = $question->fields[0]->type;
                                            $question_data['question'] = $question->label;
                                            $question_data['is_required'] = $question->required;
                                            $question_data['name'] = $question->fields[0]->name;
                                            $q = JobsQuestion::create($question_data);
                                            $question_id = $q->id;

                                            if($question->fields[0]->type == "multi_value_multi_select" || $question->fields[0]->type == "multi_value_single_select"){

                                                if ($question->fields[0]->type == "multi_value_single_select" && ($question->fields[0]->values[0]->value == 0 || $question->fields[0]->values[0]->value == 1)) {
                                                    
                                                    JobsQuestion::where('id',$question_id)->update(['type'=> 'boolean']);
                                                }else{

                                                    foreach ($question->fields[0]->values as $answer) {

                                                        $job_question = new JobsAnswer();
                                                        $job_question->question_id = $question_id;
                                                        $job_question->answer = $answer->value;
                                                        $job_question->label = $answer->label;
                                                        $job_question->save();

                                                    }
                                                }

                                            }

                                        }else{

                                            $question_db->question = $question->label;
                                            $question_db->is_required = $question->required;
                                            $question_db->type = $question->fields[0]->type;
                                            $question_db->name = $question->fields[0]->name;
                                            $question_db->status = 1;
                                            $question_db->update();

                                            JobsAnswer::Where('question_id',$question_db->id)->delete();

                                            if($question->fields[0]->type == "multi_value_multi_select" || $question->fields[0]->type == "multi_value_single_select"){

                                                if ($question->fields[0]->type == "multi_value_single_select" && ($question->fields[0]->values[0]->value == 0 || $question->fields[0]->values[0]->value == 1)) {
                                                    
                                                    JobsQuestion::where('id',$question_db->id)->update(['type'=> 'boolean']);
                                                }else{

                                                    foreach ($question->fields[0]->values as $answer) {

                                                        $job_question = new JobsAnswer();
                                                        $job_question->question_id = $question_db->id;
                                                        $job_question->answer = $answer->value;
                                                        $job_question->label = $answer->label;
                                                        $job_question->save();

                                                    }
                                                }

                                            }

                                        }

                                    }


                                    //Check Cover letter is required
                                    if ($question->label == 'Cover Letter' && $question->required == true) {
                                        
                                        Jobs::where('id',$job_post_id)->update(['is_required_coverletter'=> 1]);

                                    }else{

                                        Jobs::where('id',$job_post_id)->update(['is_required_coverletter'=> 0]);
                                    }

                                    //Check Resume is required
                                    if ($question->label == 'Resume' && $question->required == true) {
                                        
                                        Jobs::where('id',$job_post_id)->update(['is_required_resume'=> 1]);

                                    }else{

                                        Jobs::where('id',$job_post_id)->update(['is_required_resume'=> 0]);

                                    }


                                }

                            
                        }

                    }

                }

            }

        }

        if($is_rebuild) $this->generateSearchIndex();


    }

    public function syncJobsStatusByJobboard(){


        $greenhouseService = new GreenhouseService([
            'apiKey' => config('greenhouse.api_key_jobboard'),
            'boardToken' => config('greenhouse.client_token')
        ]);

        $apiService = $greenhouseService->getJobApiService();
        
        $jobs_json = $apiService->getJobs(true);
        $jobs_array = json_decode($jobs_json);
        $job_count = count($jobs_array->jobs);

        if ($job_count>0) {

            //Set all job status to off
            Jobs::where('status', 1)->update(['status'=> 0]);


            foreach ($jobs_array->jobs as $post) {

                //Get Job location
                if(!empty($post->offices[0]->name)){

                    $location_array = explode(",", $post->offices[0]->name);
                    $country = (isset($location_array[1])) ? strtolower(trim($location_array[1])) : "";
                    $city = (isset($location_array[0])) ? strtolower(trim($location_array[0])) : "";

                }else{
                    $country = "";
                    $city = "";
                }


                //Get Flag name from country
                if (!empty($country)) {
                    $country_obj = Country::where('country',$country)->first();
                    if (!empty($country_obj)) {
                        $flag = $country_obj->short;
                    }else{
                        $flag = "";
                    }
                }else{
                    $flag = "";
                }

                foreach ($post->metadata as $value) {
                    switch ($value->name) {
                        case 'Job Visibility':
                            $visibility = $value->value;
                            break;
                        default:
                            break;
                    }
                }

                //Update job status to open
                if(strtolower($visibility) == "microsite" && in_array($flag, SELF::$flag)) { 

                    Jobs::where('post_id', $post->id)->update(['status'=> 1]);

                }

            }

        }

        $this->generateSearchIndex();

    }



}
