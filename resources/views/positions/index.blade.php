@section('title', 'Positions')
<x-layout>
        <div class="bg-white">
            <header class="absolute inset-x-0 top-0 z-50">
              <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href={{ route('users.index') }} id="new-user-modal" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Users List
                    </a>
                </div>
              </nav>
            </header>
            <div class="relative isolate px-6 pt-14 lg:px-8 mx-auto max-w-[80%] my-8">
                <section class="section">
                    <table class="table-auto border-separate border-spacing-4 table-auto border-separate border-spacing-4 w-full" id="positions-table">
                        <thead>
                          <tr>
                            <th class="text-left uppercase">Id</th>
                            <th class="text-left uppercase">Name</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                </section>
            </div>
        </div>

        @push('scripts')
          <script type="module">
            $(document).ready(function() {
                $.ajax({
                    url: '/api/positions',
                    type: 'GET',
                    success: function(response) {
                        $('#positions-table tbody').empty();
                        response.positions.forEach(function(item) {
                            const row = `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.name}</td>
                                </tr>
                            `;
                            $('#positions-table tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data: ', error);
                    }
                });
            });
          </script>
        @endpush
    </x-layout>