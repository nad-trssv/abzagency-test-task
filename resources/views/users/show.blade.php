@section('title', 'Users')
<x-layout>
        <div class="bg-white">
            <header class="absolute inset-x-0 top-0 z-50">
              <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href={{ route('users.index') }} id="new-user-modal" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Users List
                    </a>
                    <a href="{{ route('positions.index') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Positions
                    </a>
                </div>
              </nav>
            </header>
            <div class="relative isolate px-6 pt-14 lg:px-8 mx-auto max-w-[80%] my-8">
                <div class="bg-white">
                    <div class="pt-6">
                      <div class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto_auto_1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
                        <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                          <img id="user-photo" alt="" class="hidden rounded-lg object-cover lg:block" height="50">
                          <h1 id="user-name" class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"></h1>
                        </div>
                    
                        <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pr-8 lg:pb-16">
                          <div class="mt-10">
                            <h3 class="text-sm font-medium text-gray-900">About</h3>
                        
                            <div class="mt-4">
                              <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                <li class="text-gray-400"><span id="user-email" class="text-gray-600"></span></li>
                                <li class="text-gray-400"><span id="user-phone" class="text-gray-600"></span></li>
                                <li class="text-gray-400"><span id="user-position" class="text-gray-600"></span></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
  
            </div>
          </div>

        @push('scripts')
          <script type="module">
            $(document).ready(function() {
                var path = window.location.pathname;
                var id = path.split('/').pop();
                $.ajax({
                    url: '/api/users/'+ id,
                    type: 'GET',
                    headers: {
                      'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                    },
                    success: function(response) {
                        renderUser(response.user);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка запроса:', xhr);
                    }
                });
            });
            function renderUser(user) {
                $('#user-name').text(user.name);
                $('#user-email').text(user.email);
                $('#user-phone').text(user.phone);
                $('#user-position').text(user.position);
                $('#user-photo').attr('src', user.photo);
            }
          </script>
        @endpush
    </x-layout>