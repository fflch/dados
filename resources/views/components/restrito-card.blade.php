    <div class="col my-3" > 
        <a href="{{ $url ?? "" }}">
            <div class="card shadow-md"  style="width: 16rem; color: black;"> 
                <div class="card-img-top" style="background-color: #dddddd">
                    
                    {{ $icon ?? ""
                     }}
                </div>

                @if(!isset($icon))
                    <svg aria-label="Placeholder: Thumbnail" class="bd-placeholder-img card-img-top" height="16rem" preserveAspectRatio="xMidYMid slice" role="img" width="100%" xmlns="http://www.w3.org/2000/svg">
                    <style>
                        text{
                            font: 2.2em sans-serif;
                            }
                    </style>
                    <title>'.$titulo.'</title>
                    <rect width="100%" height="100%" fill="#777777"></rect>
                    <text x="50%" y="50%" fill="#eceeef" dy=".3em" text-anchor="middle">{{$titulo}}</text>
                </svg> 
                @endif
                <div class="card-body">
                    <h3>{{$titulo}}</h3>
                </div>
            </div> 
        </a>
    </div>