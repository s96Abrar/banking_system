<x-guest>

    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col text-center">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-5 mx-auto">
                <form class="card card-body shadow rounded p-4" action="{{ route('users.login') }}" method="post">
                    @csrf
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
                        <button class="btn btn-block btn-primary" type="submit">Login</button>
                    </div>
                    <a href="{{ route('register') }}">Register now!!!</a>
                </form>
            </div>
        </div>
    </div>
</x-guest>
