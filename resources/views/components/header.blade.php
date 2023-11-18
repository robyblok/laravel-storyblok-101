  <div class="navbar bg-base-100">
      <div class="flex-1">
          <a href="{{ url('/')}}"  class="btn btn-ghost text-xl">Laravel x Storyblok 101</a>

      </div>
      <div class="flex-none">
          <ul class="menu menu-horizontal px-1">
              <li><a href="{{ url('/about')}}">About</a></li>
              <li><a href="{{ url('/services')}}">Services</a></li>

              <li>
                  <details>
                      <summary>
                          Parent
                      </summary>
                      <ul class="p-2 bg-base-100">
                          <li><a>Link 1</a></li>
                          <li><a>Link 2</a></li>
                      </ul>
                  </details>
              </li>
          </ul>
      </div>
  </div>
