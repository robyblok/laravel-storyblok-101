  <div class="py-24" {!! $editableAttributes !!}>

      <h2 class="text-6xl text-[#50b0ae] font-bold text-center mb-12">{{ $component["headline"] }}</h2>
      <div class="container mx-auto grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 my-12">
        @foreach($component["articles"] as $key => $value)
        <div>
            @php($article = Cache::get($value))

            <div class="card w-full bg-base-100 shadow-xl">
                <figure><img src="{{ $article["content"]["image"]["filename"]}}/m/200x100" alt="{{ $article["content"]["image"]["alt"]}}" /></figure>
                <div class="card-body">
                    <h2 class="card-title">{{ $article["content"]["title"]}}</h2>
                    <p>{{ $article["content"]["teaser"]}}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ $language=="" ? "/" : "/" . $language . "/" }}{{ $article["full_slug"] }}" class="btn btn-primary">Read More</a>


                    </div>
                </div>
            </div>
            </div>
        @endforeach
      </div>
  </div>
