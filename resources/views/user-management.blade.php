<!DOCTYPE html>
<html>
<head>
    <title>User Management - {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { margin-top: 30px; }
        .result { margin-top: 20px; padding: 15px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .user-list { max-height: 400px; overflow-y: auto; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>إدارة المستخدمين - User Management</h4>
                    </div>
                    <div class="card-body">
                        
                        <!-- User List -->
                        <div class="mb-4">
                            <h5>قائمة المستخدمين الحاليين</h5>
                            <div class="user-list">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>الاسم</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>المنصب</th>
                                            <th>المستوى</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usersList">
                                        <!-- Users will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Reset Password Form -->
                        <div class="mb-4">
                            <h5>إعادة تعيين كلمة المرور</h5>
                            <form id="resetPasswordForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="userEmail" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" id="userEmail" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="newPassword" class="form-label">كلمة المرور الجديدة</label>
                                        <input type="password" class="form-control" id="newPassword" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning mt-3">إعادة تعيين كلمة المرور</button>
                            </form>
                        </div>

                        <hr>

                        <!-- Create New User Form -->
                        <div class="mb-4">
                            <h5>إنشاء مستخدم جديد</h5>
                            <form id="createUserForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="userName" class="form-label">الاسم</label>
                                        <input type="text" class="form-control" id="userName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="userEmailNew" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" id="userEmailNew" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="userPassword" class="form-label">كلمة المرور</label>
                                        <input type="password" class="form-control" id="userPassword" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="userPosition" class="form-label">المنصب</label>
                                        <input type="text" class="form-control" id="userPosition" placeholder="مثال: admin, manager, employee">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="userLevel" class="form-label">المستوى</label>
                                        <input type="number" class="form-control" id="userLevel" value="1" min="1">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">إنشاء المستخدم</button>
                            </form>
                        </div>

                        <!-- Test Login -->
                        <div class="mb-4">
                            <h5>اختبار تسجيل الدخول</h5>
                            <form id="testLoginForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="testEmail" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" id="testEmail" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="testPassword" class="form-label">كلمة المرور</label>
                                        <input type="password" class="form-control" id="testPassword" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">اختبار تسجيل الدخول</button>
                            </form>
                        </div>

                        <div id="result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load users on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
        });

        function loadUsers() {
            fetch('/user-management/api/users')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('usersList');
                    tbody.innerHTML = '';
                    data.users.forEach(user => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.position || 'غير محدد'}</td>
                                <td>${user.level || 'غير محدد'}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" onclick="fillResetForm('${user.email}')">
                                        إعادة تعيين كلمة المرور
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => {
                    showResult('خطأ في تحميل المستخدمين: ' + error.message, 'error');
                });
        }

        function fillResetForm(email) {
            document.getElementById('userEmail').value = email;
        }

        // Reset Password Form
        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('userEmail').value;
            const password = document.getElementById('newPassword').value;

            fetch('/user-management/api/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showResult(data.message, 'success');
                    document.getElementById('resetPasswordForm').reset();
                } else {
                    showResult(data.message, 'error');
                }
            })
            .catch(error => {
                showResult('خطأ: ' + error.message, 'error');
            });
        });

        // Create User Form
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('userName').value;
            const email = document.getElementById('userEmailNew').value;
            const password = document.getElementById('userPassword').value;
            const position = document.getElementById('userPosition').value;
            const level = document.getElementById('userLevel').value;

            fetch('/user-management/api/create-user', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, email, password, position, level })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showResult(data.message, 'success');
                    document.getElementById('createUserForm').reset();
                    loadUsers(); // Reload users list
                } else {
                    showResult(data.message, 'error');
                }
            })
            .catch(error => {
                showResult('خطأ: ' + error.message, 'error');
            });
        });

        // Test Login Form
        document.getElementById('testLoginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('testEmail').value;
            const password = document.getElementById('testPassword').value;

            fetch('/user-management/api/test-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showResult(`✅ تسجيل الدخول ناجح!<br>
                                المستخدم: ${data.user.name}<br>
                                البريد الإلكتروني: ${data.user.email}<br>
                                المنصب: ${data.user.position || 'غير محدد'}`, 'success');
                } else {
                    showResult('❌ فشل تسجيل الدخول: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showResult('خطأ: ' + error.message, 'error');
            });
        });

        function showResult(message, type) {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `<div class="result ${type}">${message}</div>`;
            resultDiv.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
