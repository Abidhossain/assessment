<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center border-gray-200 mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Transaction List') }}
                        </h2>
                        <button type="button" class="btn btn-primary">
                            Current Balance : {{ $currentBalance }}
                        </button>
                    </div>

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
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->fee }}</td>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
