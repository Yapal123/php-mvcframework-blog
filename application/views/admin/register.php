<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Регистрация</div>
        <div class="card-body">
            <form action="/admin/register" method="post" class="form">
                <div class="form-group">
                    <label>Логин</label>
                    <input class="form-control" type="text" name="name">
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input class="form-control" type="password" name="password">
                </div>
                 <div class="form-group">
                    <label>Еще раз пароль</label>
                    <input class="form-control" type="password" name="password1">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
            </form>
        </div>
    </div>
</div>