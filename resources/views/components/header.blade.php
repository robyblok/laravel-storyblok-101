  <div class="navbar bg-base-100" >
      <div class="flex-1">
          <a href="{{ url('/')}}" class="btn btn-ghost text-xl">Laravel 💖 Storyblok 101 🚀</a>

      </div>
      <div class="flex-none">
          <ul class="menu menu-horizontal px-1">
              <li><a href="{{ url($language  . '/about')}}">📔 About</a></li>

              <li><a href="{{ url($language  . '/services')}}">🧑‍🚀 Services</a></li>



              <li>
                  <details>
                      <summary>
                          Language 🌐
                      </summary>
                      <ul class="p-2 bg-base-100">
                          <li><a href="/">🇬🇧 English</a></li>
                          <li><a href="/es">🇪🇸 Spanish</a></li>

                      </ul>
                  </details>
              </li>
          </ul>
      </div>
  </div>
