<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Validator;
use Config;
use Mail;
use Response;
use View;
use URL;
use Route;
use App;
use Redirect;
use Cookie;
use Notification;
use Elasticsearch;
use LinkedIn;

use App\Models\Jobs;
use App\Models\JobsQuestion;
use App\Models\JobsAnswer;
use App\Models\JobsApply;
use App\Models\ApplyAnswer;
use App\Models\ApplyCandidates;
use App\Models\Visitors;
use App\Models\City;
use \Greenhouse\GreenhouseToolsPhp\GreenhouseService;

class HomeController extends Controller
{

    public static $greenhour_userid = 512225;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        //Jobs notifications
        if(!session_id()) session_start();
        $user_session_id = session_id();
        $jobs_amount = Jobs::where('status', 1)->count();
        $cities = City::get();

        $visitor = Visitors::where('session_id',$user_session_id)->first();
        if (!empty($visitor)) {

            if($jobs_amount == $visitor->last_count){

                $jobs_last_amount = 0;

            }else{

                $jobs_last_amount = $jobs_amount - $visitor->last_count;
                $visitors['last_count'] = $jobs_amount;

                Visitors::where('session_id',$user_session_id)->update($visitors);

            }

        }else{
            $visitors['session_id'] = $user_session_id;
            Visitors::create($visitors);
            $jobs_last_amount = $jobs_amount;

        }

        //Hot Jobs
        $jobs = Jobs::where('status', 1)->orderBy('created_at', 'desc')->take(5)->get();

        return view('index')->with([
            'cities'  =>  $cities,
            'jobs'  =>  $jobs,
            'jobs_last_amount' =>$jobs_last_amount,
        ]);

    }


    /**
     * Display our story page.
     *
     * @return \Illuminate\Http\Response
     */
    public function ourStory()
    {
        $cities = City::get();
        return view('our_story')->with([
            'cities'  =>  $cities,
        ]);

    }

    /**
     * Display about us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        $cities = City::get();
        return view('about_us')->with([
            'cities'  =>  $cities,
        ]);

    }


    /**
     * Display how we hire page.
     *
     * @return \Illuminate\Http\Response
     */
    public function howWeHire()
    {
        $cities = City::get();
        return view('how_we_hire')->with([
            'cities'  =>  $cities,
        ]);

    }


    /**
     * Display business developmet page.
     *
     * @return \Illuminate\Http\Response
     */
    public function businessDevelopment()
    {
        $cities = City::get();
        return view('business_development_support')->with([
            'cities'  =>  $cities,
        ]);

    }


    /**
     * jobs search query and display results
     *
     * @param null $query
     * @param null $country
     * @param null $city
     * @return mixed
     */
    public function jobs()
    {

        //Available Jobs
        $opening_jobs_amount = Jobs::where('status', 1)->count();
        $data['opening_jobs_amount'] = $opening_jobs_amount;

        //competeion count
        $jobs_apply_amount = JobsApply::count();
        $jobs_competition_amount = (!empty($opening_jobs_amount)) ? ceil($jobs_apply_amount/$opening_jobs_amount) : 0;
        $data['jobs_competition_amount'] = $jobs_competition_amount;


        // TODO: check how safe/sanitized grabbing a parameter straight from the route is (without a route pattern)
        // grab query from post parameters, otherwise grab from url parameter
        $condition["query"] = !empty(Input::get('query')) ? Input::get('query') : null;
        $condition["country"] = !empty(Input::get('country')) ? Input::get('country') : null;
        $condition["city"] = !empty(Input::get('city')) ? Input::get('city') : null;


        $limit = 4;
        $hasMore = false;
        $cities = City::get();


        if (!empty($condition["query"])) {
            // validation
            $validation = Validator::make(['query' => $condition["query"]], ['query' => 'required|max:80|string']);

            if ($validation->fails()) {
                return view('jobs')->with([
                    'searchQuery'         =>  $condition["query"],
                    'country'             =>  $condition["country"],
                    'city'                =>  $condition["city"],
                    'cities'              =>  $cities,
                    'data'                =>  $data,
                    'errors'              =>  true,
                    'hasMore'             =>  $hasMore,
                    'validationErrors'    =>  $validation->getMessageBag(),
                ]);
            }
        }

        // search
        $result = $this->search($condition, $limit);
        if (!$result) {
            return view('jobs')->with([
                'searchQuery'         =>  $condition["query"],
                'country'             =>  $condition["country"],
                'city'                =>  $condition["city"],
                'cities'              =>  $cities,
                'data'                =>  $data,
                'hasMore'             =>  $hasMore,
                'errors'              =>  true,
                'feedback'            =>  'The website search is experiencing some issues. Please try again later.',
            ]);
        }
        elseif ($result['hits']['total'] > 0) {
            if ($result['hits']['total'] > $limit) $hasMore = true;

            return view('jobs')->with([
                'searchQuery'       =>  $condition["query"],
                'country'           =>  $condition["country"],
                'city'              =>  $condition["city"],
                'cities'            =>  $cities,                
                'data'              =>  $data,
                'errors'            =>  false,
                'hasResults'        =>  true,
                'hasMore'           =>  $hasMore,
                'results'           =>  $result['hits']['hits'],
            ]);
        }
        else {
            return view('jobs')->with([
                'searchQuery'         =>  $condition["query"],
                'country'             =>  $condition["country"],
                'city'                =>  $condition["city"],
                'cities'              =>  $cities,
                'data'                =>  $data,
                'hasMore'             =>  $hasMore,
                'errors'              =>  false,
                'hasResults'          =>  false,
            ]);
        }
    }

    /**
     * Fetch paged search results with ajax
     *
     * @return string
     */
    public function ajaxGetResults()
    {
        $validationRules = [
            'page'  => 'required|integer',
            'query' => 'required|max:80|string'
        ];

        $condition["query"] = !empty(Input::get('query')) ? Input::get('query') : null;
        $condition["country"] = !empty(Input::get('country')) ? Input::get('country') : null;
        $condition["city"] = !empty(Input::get('city')) ? Input::get('city') : null;
        $page = !empty(Input::get('page')) ? Input::get('page') : 1;

/*        $validation = Validator::make(['page' => $condition["page"], 'query' => $condition["query"]], $validationRules);

        if ($validation->fails()){
            return Response::json([
                'success'   => false,
                'errors'    => $validation->getMessageBag()->toArray(),
                'feedback'  => 'Something went wrong while processing your request. Please try again.',
            ], 200);
        }
*/
        $limit = 4;
        $noMore = true;
        $data = [];
        $content = '';
        $keyword = $condition["query"];

        $result = $this->search($condition, $limit, $limit * $page);

        if ($result['hits']['total'] > $limit * ($page + 1)) $noMore = false;



        $content .= View::make('partials.job_search_results')->with(['results' => $result['hits']['hits'], 'hasResults' => true, 'searchQuery' => $keyword]);


        $data['content'] = $content;
        $data['noMore'] = $noMore;
        $data['page'] = $page+1;


        return json_encode($data);
    }

    /**
     * Perform site search query
     *
     * @param $query
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    private function search($condition, $limit = 4, $offset = 0)
    {
        $parameters = [
            'index' =>  'booking',
            'type'  =>  'jobs',
            'size'  =>  $limit,
            'from'  =>  $offset,
        ];

        $parameters['body']['query']['bool']['must'][] = [
            'match' => [
                'status' => 1,
            ],
        ];

        if(!empty($condition['query']) || !empty($condition['country'] || !empty($condition['city']))){

            if(!empty($condition['query'])){

                $parameters['body']['query']['bool']['must'][] =  [

                      'multi_match' => [
                          'query' => $condition['query'],
                          //'type'  => 'phrase',
                          'fields' => ['title', 'description', 'requirement', 'responsibility'],
                          'fuzziness' => 'AUTO',
                          'prefix_length' => 0,
                      ],
                ];

            }

            if(!empty($condition['country'])){

                $parameters['body']['query']['bool']['must'][] = [
                    'match' => [
                        'country' => $condition['country'],
                    ],
                ];

            }

            if(!empty($condition['city'])){

                $parameters['body']['query']['bool']['must'][] = [
                    'match' => [
                        'city' => $condition['city'],
                    ],
                ];

            }

        }

        // var_dump($parameters);exit;
        try {
            return Elasticsearch::search($parameters);
        }
        catch(\Exception $e) {

            echo $e->getMessage();
            exit;
            // email error to developer
/*
            $recipient = Config::get('settings.developer-email');
            $subject = 'Error on ' . Config::get('app.domain') . ' while trying to use Elasticsearch';
            Mail::send('emails.errors.general', ['error' => $e->getMessage()], function($message) use ($recipient, $subject)
            {
                $message->subject($subject);
                $message->to($recipient);
            });
*/

            return false;
        }

    }



    /**
     * display job detail
     *
     * @param null $job_id
     * @return mixed
     */
    public function jobsDetail($id)
    {

        $jobs = Jobs::findOrFail($id);

        $job_country = "";
        $job_country .= $jobs->country()->get();
        $country  = json_decode($job_country);

        $relative_jobs = Jobs::where('id','!=',$id)->whereOr('city',$jobs->city)->whereOr('country',$jobs->country)->limit(3)->get();

        return view('jobs_detail')->with([
            'jobs'  =>  $jobs,
            'country'  =>  $country[0]->country_cn,
            'relative_jobs'  =>  $relative_jobs,
        ]);

    }


    /**
     * apply
     *
     * @param null $job_id
     * @return mixed
     */
    public function jobsApply()
    {

        $id = Input::get('id');
        $if_cancel = !empty(Input::get('if_cancel')) ? Input::get('if_cancel') : null;
        $ln['resume'] = array('firstName'=>'','lastName'=>'','emailAddress'=>'','phoneNumbers'=>'','publicProfileUrl'=>'');


        if($if_cancel){

            //if not authenticated
            LinkedIn::clearStorage();
            return Redirect::to(URL::Route('jobs-apply',['id'=>$id]));

        }else{

            if (LinkedIn::isAuthenticated()) {
                //we know that the user is authenticated now. Start query the API
                $user=LinkedIn::get('v1/people/~:(firstName,lastName,emailAddress,phoneNumbers,publicProfileUrl)');
                // var_dump($user);exit;

                if(!isset($user['lastName'])) $user['lastName'] = "";
                if(!isset($user['emailAddress'])) $user['emailAddress'] = "";
                if(!isset($user['phoneNumbers'])) $user['phoneNumbers'] = "";
                $ln['resume'] = $user;
                $is_linkedin = 1;
            }else{
                //if (LinkedIn::hasError())
                $ln_url = LinkedIn::getLoginUrl();
                $ln['ln_url'] = $ln_url;
                $is_linkedin = 0;

            }

        }



        $ln['is_linkedin'] = $is_linkedin;
        $jobs = Jobs::findOrFail($id);


        return view('jobs_apply')->with([
            'jobs'  =>  $jobs,
            'linkedin'  =>  $ln
        ]);

    }


    /**
     * display apply question
     *
     * @param null $job_id
     * @return mixed
     */
    public function jobsApplySubmit(Request $request)
    {

        $resume_path = "uploads/resume/";
        $coverletter_path = "uploads/coverletter/";
        $file_permission = array('csv','doc','docx','pdf','txt','jpg','jpeg','png','bmp');
        $file_name = time();


        $validationRules = [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => 'required|email',
            'mobile' => 'required|max:30',
            'resume' => 'required|file|mimes:csv,doc,docx,pdf,txt,jpg,jpeg,png,bmp',
        ];

        if(!empty(Input::get('is_required_coverletter'))){
            $validationRules['cover_letter'] = 'required|file|mimes:csv,doc,docx,eml,pdf,txt,jpg,jpeg,png,bmp';

        }else{

            $validationRules['cover_letter'] = 'file|mimes:csv,doc,docx,eml,pdf,txt,jpg,jpeg,png,bmp';
        }

        $validation = Validator::make($request->all(), $validationRules);

        if ($validation->fails()){
            //Notification::error('There were errors while creating your article. Please refer to the error messages below');

            return Redirect::back()->withErrors($validation)->withInput();
        }


        if(Input::get('linkedin_url')) $apply['linkedin_url'] = Input::get('linkedin_url');

        if(!empty(Input::file('resume'))){

            $resume = Input::file('resume');

            if($resume->isValid()){
                $extension = $resume->getClientOriginalExtension();
                $resume_file_size = round($resume->getSize()/1024);
                $resume_file_name = "resume_".$file_name.".".$extension;


                if(in_array($extension, $file_permission) && $resume_file_size < 5120){

                    $resume->move(public_path($resume_path),$resume_file_name);
                    $apply['resume'] = $resume_file_name;

                }

            }

        }

        if(!empty(Input::file('cover_letter'))){

            $cover_letter = Input::file('cover_letter');
            if($cover_letter->isValid()){

                $extension = $cover_letter->getClientOriginalExtension();
                $coverletter_file_size = round($cover_letter->getSize()/1024);
                $coverletter_file_name = "cl_".$file_name.".".$extension;


                if(in_array($extension, $file_permission) && $coverletter_file_size < 5120){

                    $cl_uplaod_result = $cover_letter->move(public_path($coverletter_path),$coverletter_file_name);
                    $apply['cover_letter'] = $coverletter_file_name;

                }

            }

        }

        //Insert To apply

        if(!session_id()) session_start();
        $user_session_id = session_id();  
        $apply['session_id'] = $user_session_id;
        $apply['parent_id'] = Input::get('parent_id');
        $apply['job_id'] = Input::get('job_id');
        $apply['post_id'] = Input::get('post_id');
        $apply['first_name'] = Input::get('first_name');
        $apply['last_name'] = Input::get('last_name');
        $apply['email'] = Input::get('email');
        $apply['mobile'] = Input::get('mobile');

        $apply_id = JobsApply::create($apply);


        return Redirect::route('jobs-apply-question',$apply_id);


    }



    public function JobsApplyQuestion($id)
    {


        $apply = JobsApply::where('is_answer',0)->findOrFail($id);
        $job_id = $apply->parent_id;
        $jobs = Jobs::findOrFail($job_id);
        $questions = JobsQuestion::where('parent_id',$job_id)->get();


        return view('jobs_apply_question')->with([
            'jobs'  =>  $jobs,
            'questions'  =>  $questions,
            'apply' => $apply,
        ]);

    }


    /**
     * complete apply
     *
     * @param null $job_id
     * @return mixed
     */
    public function JobsApplyComplete()
    {

        //Get Input variable
        $apply_id = Input::get('apply_id');

        $apply = JobsApply::where('is_answer',0)->findOrFail($apply_id);
        $job_id = $apply->parent_id;

        //Genrate posts variable array 
        $postVars['id'] = $apply->post_id;
        $postVars['first_name'] = $apply->first_name;
        $postVars['last_name'] = $apply->last_name;
        $postVars['email'] = $apply->email;
        $postVars['phone'] = $apply->mobile;



        $answer_data['apply_id'] = $apply_id;

        foreach (Input::all() as $qid => $answer) {
            if(substr($qid, 0, 8) == "question"){

                $question_id = substr($qid, 9);
                $answer_data['question_id'] = $question_id;

                if(!is_array($answer)){

                    $postVars[$qid] = strip_tags($answer);
                    $answer_data['answer'] = strip_tags($answer);

                }else{
                    $postVars[$qid] = $answer;

                    $answer_string = implode(',', $answer);
                    $answer_data['answer'] = $answer_string;
                }

                ApplyAnswer::create($answer_data);


            }
        }



        //Generate apply json string
     
        if (!empty($apply->resume)) {

            $resume_path = public_path("uploads/resume/".$apply->resume);
            $resume_file_type = mime_content_type($resume_path);

            $resume_file_stream = base64_encode($resume_path);
            $apply_array["attachments"][] = array("filename"=>$apply->resume, "type"=>"resume", "content"=>$resume_file_stream, "content_type"=>stripslashes($resume_file_type));

        }


        if(!empty($apply->cover_letter)){

            $coverletter_path = public_path("uploads/coverletter/".$apply->cover_letter);
            $cover_file_type = mime_content_type($coverletter_path);

            $cover_file_stream = base64_encode($coverletter_path);
            $apply_array["attachments"][] = array("filename"=>$apply->cover_letter, "type"=>"resume", "content"=>$cover_file_stream, "content_type"=>stripslashes($cover_file_type));

        }
        

/*
        //$attachments_json = (isset($apply_array["attachments"])) ? ',"attachments":'.json_encode($apply_array["attachments"]) : "";

        if(!empty($apply->linkedin_url)){

            $social_media["value"] = $apply->linkedin_url;
            $social_json_string = '"social_media_addresses":['.json_encode($social_media).'],';
        }else{

            $social_json_string = "";

        }

*/
        if(!empty($apply->resume)) $postVars['resume'] = new \CURLFile($resume_path, null, $apply->resume);
        if(!empty($apply->cover_letter)) $postVars['cover_letter'] = new \CURLFile($coverletter_path, null, $apply->cover_letter);



        //Application submit by Job Board
        $greenhouseService = new GreenhouseService([
            'apiKey' => config('greenhouse.api_key_jobboard'),
            'boardToken' => config('greenhouse.client_token')
        ]);

        $appService = $greenhouseService->getApplicationApiService();
        $apiService = $greenhouseService->getJobApiService();
        

        //var_dump($postVars);exit;
        $submit_return = $appService->postApplication($postVars);

        $submit_return_array = json_decode($submit_return);

        if(isset($submit_return_array->success)){

            //update is answer to true
            $apply->is_answer = 1;
            $apply->update();    //Set Application Answer Status

            //Add candidcate archive
            $apply_candidcate = new ApplyCandidates();
            $apply_candidcate->apply_id = $apply_id;
            $apply_candidcate->email = $apply->email;
            $apply_candidcate->application_id = $apply->id;
            $apply_candidcate->apply_created_at = date("Y-m-d H:i:s");
            $apply_candidcate->save();

            //Count apply number
            Jobs::where('id',$job_id)->update(['apply_count' => 'apply_count'+1]);

            $feedback = "1";

        }else{

            $feedback = "2";
        }


/*
        //Application Json
        $apply_job_id = $apply->job_id;//462148; //
        $json_string = '{
          "first_name": "'.$apply->first_name.'",
          "last_name": "'.$apply->last_name.'",
          "is_private": false,
          "phone_numbers": [
            {
              "value": "'.$apply->mobile.'",
              "type": "mobile"
            }
          ],
          "email_addresses": [
            {
              "value": "'.$apply->email.'",
              "type": "personal"
            }
          ],
          '.$social_json_string.'
          "applications": [
            {
              "job_id": '.$apply_job_id.$attachments_json.'

            }
          ]
        }';
        
        //var_dump($json_string);exit;


        //Submit to Harest of Greenhouse
        $greenhouseService = new GreenhouseService([
            'apiKey' => config('greenhouse.api_key'),
        ]);
        $harvestService = $greenhouseService->getHarvestService();
        
        
        $params = array(
            'headers' => array('On-Behalf-Of' => self::$greenhour_userid),
            'body' => $json_string,
        );
        
        //Post to Greenhouse by hervast
        try {

            $apply_json_return = $harvestService->postCandidate($params);
            
        } catch (Exception $e) {

            $feedback = "2";

        }

        //Insert new candidcate
        $apply_array_retrun = json_decode($apply_json_return);
        $apply_candidcate = new ApplyCandidates();
        $apply_candidcate->apply_id = $apply_id;
        $apply_candidcate->email = $apply->email;
        $apply_candidcate->candidate_id = $apply_array_retrun->id;
        $apply_candidcate->application_id = $apply_array_retrun->applications[0]->id;
        $apply_candidcate->apply_created_at = $apply_array_retrun->created_at;
        $apply_candidcate->save();

        Jobs::where('id',$job_id)->update(['apply_count' => 'apply_count'+1]);
*/
        

        return view('jobs_apply_complete')->with([
            'feedback'  =>  $feedback,
        ]);

    }


    /*
     * Switch to another language
     */
    public function switchLanguage($locale = 'cn', Request $request)
    {
        $url = URL::previous();

//        $domain = parse_url($url, PHP_URL_HOST);
//
//        // only allow whitelisted referrers
//        $allowedReferrers = Config::get('app.allowed-referrers');
//        $allowed = false;
//
//        foreach ($allowedReferrers as $referrer) {
//            if (preg_match('/'.$referrer.'/', $domain) == true) $allowed = true;
//        }
//
//        if ($allowed == false) return Redirect::route('home');


        $currentLocale = App::getLocale();

        // If the new locale is the same as the current one, just redirect back to the original page
        if ($currentLocale == $locale) {
            return Redirect::to($url);
        }

        $secure = $request->secure();

        $path = parse_url($url, PHP_URL_PATH);
        $param = parse_url($url, PHP_URL_QUERY);
        if(!empty($param)) $param =  "?".$param;

        // No path = home page
        if ($path == null || $path == '/' || $path == '/'.$currentLocale) {
            App::setLocale($locale);
            Cookie::queue('locale', $locale, 60 * 24 * 365 * 2, '/', null, $secure); // 2 years

            return Redirect::to(self::updateUrlLocale($path, $locale, $currentLocale, ''));
        }

        // Replace the old locale URL segment for the new one
        $path = self::updateUrlLocale($path, $locale, $currentLocale);


        App::setLocale($locale);
        Cookie::queue('locale', $locale, 60 * 24 * 365 * 2, '/', null, $secure); // 2 years

        return Redirect::to($path.$param);
    }

    /*
     * Replace the current locale in the URL with the new one
     */
    private function updateUrlLocale($path, $newLocale, $oldLocale, $trailingSlash = '/')
    {
        // if the old locale is the default locale
        if ($oldLocale == 'cn') {
            // return the path unchanged if the new locale is also the default locale
            if ($newLocale == 'cn') {
                return $path;
            }
            // otherwise, prefix the old path with the new locale
            return '/'.$newLocale.$path;

        } else {
            if ($newLocale == 'cn') {
                // Remove the locale param from the path
                return str_replace('/'.$oldLocale.$trailingSlash, '/', $path);
            } else {
                // replace the old locale param in the url by the new one
                return str_replace('/'.$oldLocale.$trailingSlash, '/'.$newLocale.'/', $path);
            }
        }
    }





}
