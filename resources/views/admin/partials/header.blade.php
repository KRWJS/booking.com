<header>
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('comasy.dashboard') }}">Booking CMS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if(Auth::user())
                    <li><a href="{{ route('comasy.jobs.index') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Jobs</a></li>
                    <li><a href="{{ route('comasy.application.index') }}"><i class="fa fa-pencil" aria-hidden="true"></i> Application</a></li>
                    <li><a href="{{ route('comasy.user.index') }}"><i class="fa fa-users" aria-hidden="true"></i> Admin</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        @if(Auth::user())
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }}  <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('comasy.user.edit', ['id' => Auth::user()->id]) }}"><i class="fa fa-btn fa-wrench"></i> Settings</a></li>
                                <li><a href="{{ route('comasy.logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                            </ul>
                        @endif
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
