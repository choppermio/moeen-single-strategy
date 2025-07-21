<!DOCTYPE html>
<html>
<head>
    <title>Login Debug - {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .debug-box { background: white; padding: 20px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border-color: #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border-color: #bee5eb; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔍 Login Debug Interface</h2>
        
        <div class="debug-box info">
            <h4>Database Connection Status</h4>
            <p>✅ Database connected successfully</p>
            <p><strong>Total Users:</strong> {{ $totalUsers }}</p>
        </div>

        <div class="debug-box">
            <h4>Available Users</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Password Hash</th>
                        <th>Quick Reset</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->position ?? 'N/A' }}</td>
                        <td><code>{{ substr($user->password, 0, 20) }}...</code></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="resetPassword('{{ $user->email }}')">
                                Reset to "123456"
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="debug-box">
            <h4>🔧 Test Authentication</h4>
            <form id="authTestForm">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" id="testEmail" class="form-control" value="ceo@moeen-sa.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <input type="password" id="testPassword" class="form-control" value="123456">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary">Test Auth</button>
                    </div>
                </div>
            </form>
            <div id="authResult" class="mt-3"></div>
        </div>

        <div class="debug-box">
            <h4>🔗 Quick Actions</h4>
            <a href="{{ route('login') }}" class="btn btn-success">Go to Login Page</a>
            <button onclick="resetAllPasswords()" class="btn btn-warning">Reset All Passwords to 123456</button>
            <button onclick="testHashFunction()" class="btn btn-info">Test Hash Function</button>
        </div>

        <div id="results"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showResult(message, type = 'info') {
            const div = document.getElementById('results');
            div.innerHTML = `<div class="debug-box ${type}"><strong>Result:</strong> ${message}</div>`;
        }

        function resetPassword(email) {
            fetch('/debug-login/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    location.reload();
                }
            });
        }

        function resetAllPasswords() {
            if (confirm('Are you sure you want to reset all user passwords to "123456"?')) {
                fetch('/debug-login/reset-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    showResult(data.message, data.success ? 'success' : 'error');
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        function testHashFunction() {
            fetch('/debug-login/test-hash', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                showResult(`Hash Test: ${data.hash}`, 'info');
            });
        }

        document.getElementById('authTestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('testEmail').value;
            const password = document.getElementById('testPassword').value;

            fetch('/debug-login/test-auth', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('authResult');
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="debug-box success">
                            <h5>✅ Authentication Successful!</h5>
                            <p><strong>User:</strong> ${data.user.name}</p>
                            <p><strong>Email:</strong> ${data.user.email}</p>
                            <p><strong>ID:</strong> ${data.user.id}</p>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="debug-box error">
                            <h5>❌ Authentication Failed</h5>
                            <p><strong>Error:</strong> ${data.message}</p>
                            <p><strong>Debug Info:</strong> ${data.debug || 'None'}</p>
                        </div>
                    `;
                }
            });
        });
    </script>
</body>
</html>
