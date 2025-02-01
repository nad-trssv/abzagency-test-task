<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Users list</title>
        
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="bg-white">
            <header class="absolute inset-x-0 top-0 z-50">
              <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="hidden lg:flex lg:gap-x-12">
                    <button id="new-user-modal" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Create New User
                    </button>
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
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                </section>
                <div class="text-right mt-4">
                    <button id="load-more-btn" class="bg-orange-400 text-white font-semibold py-2 px-4 rounded-lg hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-blue-300">
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
                            <label for="password" class="block text-gray-700">Password</label>
                            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <div id="password-error" class="error-message text-red-500 text-sm mt-1"></div>
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-md">
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

        
          <script type="module">
            let currentPage = 1;
            let users = [];

            $(document).ready(function() {
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
                    formData.append('password', $('#password').val());
                    formData.append('password_confirmation', $('#password_confirmation').val());

                    $.ajax({
                        url: '/api/users',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
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
                                console.log('There was an unexpected error.');
                            }
                        }
                    });
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
                                <img src="${user.photo}" alt="${user.name}" width="50" height="50" class="rounded-xl shadow-lg shadow-gray-800">
                                <p>${user.name}</p>
                            </td>
                            <td>
                                <a class="text-blue-700"  href="mailto:${user.email}">${user.email}</a>
                            </td>
                            <td>
                                <a class="text-blue-700" href="tel:${user.phone}">${user.phone}</a>
                            </td>
                            <td>${user.position}</td>
                        </tr>
                    `;
                    $('#users-table tbody').append(row);
                });
            }
          </script>
    </body>
</html>
