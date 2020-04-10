@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route("songs.store")}}" method="POST" autocomplete="off">
                            @method("post")
                            @csrf
                            <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-artist_name">{{ __('Song title') }} *</label>
                                <div class="autocomplete">
                                    <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Song title') }}">
                                </div>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('uri') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-song_uri">{{ __('Song link') }} *</label>
                                <div class="autocomplete">
                                    <input readonly type="text" name="uri" id="input-uri" class="form-control form-control-alternative{{ $errors->has('uri') ? ' is-invalid' : '' }}" placeholder="{{ __('Song uri') }}">
                                </div>
                                @if ($errors->has('uri'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('uri') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('length') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-song_uri">{{ __('Length (seconds)') }} *</label>
                                <div class="autocomplete">
                                    <input readonly type="text" name="length" id="input-length" class="form-control form-control-alternative{{ $errors->has('length') ? ' is-invalid' : '' }}" placeholder="{{ __('Length in seconds') }}">
                                </div>
                                @if ($errors->has('length'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('length') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Save</button>
                            @push("js")
                                <script>
                                    function autocomplete(inp) {
                                        var arr = [];
                                        /*the autocomplete function takes two arguments,
                                        the text field element and an array of possible autocompleted values:*/
                                        var currentFocus;
                                        /*execute a function when someone writes in the text field:*/
                                        inp.addEventListener("input", function(e) {
                                            var a, b, i, val = this.value;
                                            /*close any already open lists of autocompleted values*/
                                            closeAllLists();
                                            if (!val) { return false;}
                                            currentFocus = -1;
                                            /*create a DIV element that will contain the items (values):*/
                                            a = document.createElement("DIV");
                                            a.setAttribute("id", this.id + "autocomplete-list");
                                            a.setAttribute("class", "autocomplete-items");
                                            /*append the DIV element as a child of the autocomplete container:*/
                                            this.parentNode.appendChild(a);
                                            @if(env("APP_ENV") == "production")
                                            axios.get("/public/spotify/search/song/" + $(this).val())
                                                .then(function(response){
                                                    arr = [];
                                                    for(let i = 0; i < response.data.items.length; i++){
                                                        let song = response.data.items[i];
                                                        console.log(song);
                                                        arr.push([song.name, song.album.images[2], song.external_urls.spotify, song.duration_ms]);
                                                    }
                                                });
                                            @else
                                            axios.get("/spotify/search/song/" + $(this).val())
                                                .then(function(response){
                                                    arr = [];
                                                    for(let i = 0; i < response.data.items.length; i++){
                                                        let song = response.data.items[i];
                                                        console.log(song);
                                                        arr.push([song.name, song.album.images[2], song.external_urls.spotify, song.duration_ms]);
                                                    }
                                                });
                                            @endif

                                            /*for each item in the array...*/
                                            for (let i = 0; i < arr.length; i++) {
                                                /*check if the item starts with the same letters as the text field value:*/
                                                if (arr[i][0].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                                    /*create a DIV element for each matching element:*/
                                                    b = document.createElement("DIV");
                                                    /*make the matching letters bold:*/
                                                    b.innerHTML = "<img style='margin-right: 5px' class='rounded-circle' height='25' src='"+arr[i][1].url+"' /><strong>" + arr[i][0].substr(0, val.length) + "</strong>";
                                                    b.innerHTML += arr[i][0].substr(val.length);
                                                    /*insert a input field that will hold the current array item's value:*/
                                                    b.innerHTML += "<input type='hidden' value='" + arr[i][0] + "'>";
                                                    b.innerHTML += "<input type='hidden' value='" + arr[i][1].url + "'>";
                                                    b.innerHTML += "<input type='hidden' value='" + arr[i][2] + "'>";
                                                    b.innerHTML += "<input type='hidden' value='" + arr[i][3] + "'>";
                                                    /*execute a function when someone clicks on the item value (DIV element):*/
                                                    b.addEventListener("click", function(e) {
                                                        inp.value = this.getElementsByTagName("input")[0].value;
                                                        $("#artist_name_paragraph").text(this.getElementsByTagName("input")[0].value);
                                                        $("#artist_uri_btn").attr("href", this.getElementsByTagName("input")[2].value);
                                                        $(".artist__image").attr("src", this.getElementsByTagName("input")[1].value);
                                                        $(".artist__blur").attr("src", this.getElementsByTagName("input")[1].value);
                                                        $("#artist-card").show();
                                                        /*insert the value for the autocomplete text field:*/
                                                        document.getElementById("input-uri").value =  this.getElementsByTagName("input")[2].value;
                                                        document.getElementById("input-length").value = Math.ceil(this.getElementsByTagName("input")[3].value / 1000);
                                                        /*close the list of autocompleted values,
                                                        (or any other open lists of autocompleted values:*/
                                                        closeAllLists();
                                                    });
                                                    a.appendChild(b);
                                                }
                                            }
                                        });
                                        /*execute a function presses a key on the keyboard:*/
                                        inp.addEventListener("keydown", function(e) {
                                            var x = document.getElementById(this.id + "autocomplete-list");
                                            if (x) x = x.getElementsByTagName("div");
                                            if (e.keyCode == 40) {
                                                /*If the arrow DOWN key is pressed,
                                                increase the currentFocus variable:*/
                                                currentFocus++;
                                                /*and and make the current item more visible:*/
                                                addActive(x);
                                            } else if (e.keyCode == 38) { //up
                                                /*If the arrow UP key is pressed,
                                                decrease the currentFocus variable:*/
                                                currentFocus--;
                                                /*and and make the current item more visible:*/
                                                addActive(x);
                                            } else if (e.keyCode == 13) {
                                                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                                                e.preventDefault();
                                                if (currentFocus > -1) {
                                                    /*and simulate a click on the "active" item:*/
                                                    if (x) x[currentFocus].click();
                                                }
                                            }
                                        });
                                        function addActive(x) {
                                            /*a function to classify an item as "active":*/
                                            if (!x) return false;
                                            /*start by removing the "active" class on all items:*/
                                            removeActive(x);
                                            if (currentFocus >= x.length) currentFocus = 0;
                                            if (currentFocus < 0) currentFocus = (x.length - 1);
                                            /*add class "autocomplete-active":*/
                                            x[currentFocus].classList.add("autocomplete-active");
                                        }
                                        function removeActive(x) {
                                            /*a function to remove the "active" class from all autocomplete items:*/
                                            for (var i = 0; i < x.length; i++) {
                                                x[i].classList.remove("autocomplete-active");
                                            }
                                        }
                                        function closeAllLists(elmnt) {
                                            /*close all autocomplete lists in the document,
                                            except the one passed as an argument:*/
                                            var x = document.getElementsByClassName("autocomplete-items");
                                            for (var i = 0; i < x.length; i++) {
                                                if (elmnt != x[i] && elmnt != inp) {
                                                    x[i].parentNode.removeChild(x[i]);
                                                }
                                            }
                                        }
                                        /*execute a function when someone clicks in the document:*/
                                        document.addEventListener("click", function (e) {
                                            closeAllLists(e.target);
                                        });
                                    }

                                    autocomplete(document.getElementById("input-title"));
                                </script>
                            @endpush
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 order-xl-1" id="artist-card" style="display: none;">
                <div class="artist__thumbnail">
                    <img class="artist__blur" src="#">
                    <img class="artist__image" src="#">
                    <div class="artist__ring"></div>
                    <div class="artist__ring artist__ring--outer"></div>
                </div>
                <div class="artist__label">
                    <p id="artist_name_paragraph">Rival Consoles</p>
                    <a target="_blank" href="#" class="btn btn-outline-success" id="artist_uri_btn">SEE SONG</a>
                </div>
            </div>
        </div>
    </div>
@endsection
