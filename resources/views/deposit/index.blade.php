<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center border-gray-200 mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Deposit List') }}
                        </h2>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#depositModal">
                            Deposit
                        </button>
                    </div>

                    <!-- Success message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                                <th>User</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposits as $deposit)
                                <tr>
                                    <td>{{ $deposit->transaction_type }}</td>
                                    <td>{{ $deposit->amount }}</td>
                                    <td>{{ $deposit->fee }}</td>
                                    <td>{{ $deposit->date }}</td>
                                    <td>{{ $deposit->user->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $deposits->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositModalLabel">Deposit Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('deposit.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Deposit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
