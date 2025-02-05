@section('title', 'Users')
<x-layout>
        <div class="bg-white">
            <header class="absolute inset-x-0 top-0 z-50">
              <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="hidden lg:flex lg:gap-x-12">
                    <button id="new-user-modal" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Create New User
                    </button>
                    <a href="{{ route('positions.index') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Positions
                    </a>
                    <button id="logout" class="hidden bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Logout
                    </button>
                    <a href="{{ route('documentation.index') }}" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                        Api Docs 
                    </a>
                </div>
              </nav>
            </header>
          
            <div class="relative isolate px-6 pt-14 lg:px-8 mx-auto max-w-[80%] my-8">
                <section class="section">
                    <table class="table-auto border-separate border-spacing-4 table-auto border-separate border-spacing-4 w-full" id="users-table">
                        <thead>
                          <tr>
                            <th class="text-left uppercase">Name</th>
                            <th class="text-left uppercase">Email</th>
                            <th class="text-left uppercase">Phone</th>
                            <th class="text-left uppercase">role</th>
                            <th class="text-left uppercase"></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                </section>
                <div class="text-right mt-4">
                    <button id="load-more-btn" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Show more
                    </button>
                </div>
            </div>
          </div>
          <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden z-50">
            <div class="flex justify-center items-center h-full">
                <div class="bg-white rounded-lg p-6 w-full max-w-md">
                    <h2 class="text-xl font-semibold mb-4">Create New User</h2>
                    <form id="user-form" enctype="multipart/form-data"> 
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <div id="name-error" class="error-message text-red-500 text-sm mt-1"></div>
                        </div>
        
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <div id="email-error" class="error-message text-red-500 text-sm mt-1"></div>
                        </div>
        
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700">Phone</label>
                            <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <div id="phone-error" class="error-message text-red-500 text-sm mt-1"></div>
                        </div>
        
                        <div class="mb-4">
                            <label for="position_id" class="block text-gray-700">Position</label>
                            <input type="number" id="position_id" name="position_id" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <div id="position_id-error" class="error-message text-red-500 text-sm mt-1"></div>
                        </div>
                        <div class="mb-4">
                            <label for="photo" class="block text-gray-700">photo</label>
                            <input type="file" id="photo" name="photo" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <div id="photo-error" class="error-message text-red-500 text-sm mt-1"></div>
                        </div>
        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                            <button type="button" id="close-modal" class="px-4 py-2 bg-gray-500 text-white rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
          <script type="module">
            let currentPage = 1;
            let users = [];

            $(document).ready(function() {
                //Check token and activation logout button 
                const token = localStorage.getItem('auth_token');
                if (token) {
                  $('#logout').removeClass('hidden');
                } else {
                  let tokenEl = document.querySelectorAll('.getToken');
                  tokenEl.forEach(function(el) {
                      el.textContent = ''; 
                  });
                  $('#logout').addClass('hidden');
                }

                loadUsers(currentPage, false);
                $('#load-more-btn').click(function() {
                    currentPage++;
                    loadUsers(currentPage, false);
                });


                // Open Modal "new user"
                $('#new-user-modal').click(function() {
                    $('#modal').removeClass('hidden');
                });
                // Close Modal "new user"
                $('#close-modal').click(function() {
                    $('#modal').addClass('hidden');
                });
                $('#user-form').submit(function(event) {
                    event.preventDefault();
                    let formData = new FormData($('#user-form')[0]);
                    let photoInput = $('#photo')[0];
                    if (photoInput.files.length > 0) {
                        formData.append('photo', photoInput.files[0]);
                    }

                    $.ajax({
                        url: '/api/users',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                          'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                        },
                        success: function(response) {
                            $('#modal').addClass('hidden');
                            currentPage = 1;
                            loadUsers(currentPage, true);
                        },
                        error: function(xhr) {
                            $('.error-message').empty();   
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                            
                                //  Error validation
                                Object.keys(errors).forEach(function(field) {
                                    let errorText = errors[field].join(', ');
                                    $(`#${field}-error`).text(errorText);
                                });
                            } else {
                                alert('Not authorized!');
                            }
                        }
                    });
                });

                $('#logout').click(function(){
                    removeToken();
                });
            });
            function loadUsers(page, clear) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: `/api/users?page=${page}`,
                    type: 'GET',
                    success: function(response) {
                        const newUsers = response.users;
                        if(clear === true){
                            users = [...newUsers];
                        } else {
                            users = [...users, ...newUsers];
                        }
                        renderUsers();
                        if (response.page >= response.total_pages) {
                            $('#load-more-btn').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data: ', error);
                    }
                });
            }
            function renderUsers() {
                $('#users-table tbody').empty();
                users.forEach(function(user) {
                    const row = `
                        <tr>
                            <td class="inline-flex items-center gap-4">
                                <a href="/users/${user.id}">
                                <img src="${user.photo}" alt="${user.name}" width="50" height="50" class="rounded-xl shadow-lg shadow-gray-800">
                                <p>${user.name}</p>
                                </a>
                            </td>
                            <td>
                                <a class="text-blue-700"  href="mailto:${user.email}">${user.email}</a>
                            </td>
                            <td>
                                <a class="text-blue-700" href="tel:${user.phone}">${user.phone}</a>
                            </td>
                            <td>${user.position}</td>
                            <td>
                                <button class="login-btn text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                    Get token
                                </button>
                                <p class="getToken" data-userId="${user.id}"></p>
                            </td>
                        </tr>
                    `;
                    $('#users-table tbody').append(row);
                });
                $('.login-btn').on('click', function() {
                    console.log('pressed login btn');
                    const email = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                    $.ajax({
                        url: '/api/token',
                        type: 'POST',
                        data: { email: email},
                        success: function(response) {
                            console.log('login response');
                            console.log(response);
                            let tokenEl = document.querySelectorAll('.getToken');
                            tokenEl.forEach(function(el) {
                                el.textContent = ''; 
                            });
                            let datauserId = document.querySelector(`[data-userId='${response.user.id}']`);
                            if (datauserId) {
                                datauserId.textContent = response.token;
                            }
                            if (response.token) {
                              // Сохраняем токен в localStorage
                              localStorage.setItem('auth_token', response.token);
                            } else {
                              console.log('Login failed');
                            }
                            //Activate logout button
                            $('#logout').removeClass('hidden');
                        },
                        error: function(xhr) {
                            alert('Failed');
                            console.error('Error logging in: ', xhr.responseText);
                        }
                    });
                });
            }
            function removeToken() {
                const token = localStorage.getItem('auth_token');
                $.ajax({
                    url: '/api/logout',
                    type: 'POST',
                    data: token,
                    processData: false,
                    contentType: false,
                    headers: {
                      'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                    },
                    success: function(response) {
                        let tokenEl = document.querySelectorAll('.getToken');
                            tokenEl.forEach(function(el) {
                            el.textContent = ''; 
                        });
                        localStorage.removeItem('auth_token');
                        $('#logout').addClass('hidden');
                    },
                    error: function(xhr) {
                        console.log('error');
                        $('#logout').removeClass('hidden');
                    }
                });
            }
          </script>
        @endpush
    </x-layout>