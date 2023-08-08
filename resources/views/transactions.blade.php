<x-master>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col text-center">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h5 class="text-end">Account balance: {{ auth()->user()->balance }}</h5>
            <h3>All Transactions</h3>
            <div class="text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#depositModal">Deposit</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#withdrawModal">Withdraw</button>
            </div>
            <div class="col">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Transaction Type</th>
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
                                <td>{{ $transaction->transaction_type }}</td>
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


    <!-- Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('deposits.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="depositModalLabel">Deposit money</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amountInput" class="form-label">Amount</label>
                            <input type="number" name="amount" class="form-control" id="amountInput" required>
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('withdraw.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="withdrawModalLabel">Withdraw money</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amountInput" class="form-label">Amount</label>
                            <input type="number" name="amount" class="form-control" id="amountInput" required>
                            @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-master>
