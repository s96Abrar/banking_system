<x-guest>
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
            <div class="col-5 mx-auto">
                <form class="card card-body shadow rounded p-4" action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="nameInput" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="accountTypeInput" class="form-label">Account Type</label>
                        <select name="account_type" class="form-control" id="accountTypeInput" required>
                            <option value="" disabled selected>None</option>
                            <option value="individual">Individual</option>
                            <option value="business">Business</option>
                        </select>
                        @error('account_type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="emailInput" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="passwordInput" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="passwordConfirmInput" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            id="passwordConfirmInput" required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-block btn-primary" type="submit">Register</button>
                    </div>
                    <a href="{{ route('login') }}">Login now!!!</a>
                </form>
            </div>
        </div>
    </div>
</x-guest>
