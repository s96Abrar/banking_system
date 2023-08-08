<x-master>
    <div class="container mt-5 pt-5">
        <div class="row">
            <h3>Withdrawal Transactions</h3>
            <div class="col">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->user->name }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->fee }}</td>
                            <td>{{ $transaction->date->toDateString() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No Transactions</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-master>
