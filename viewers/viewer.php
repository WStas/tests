<!doctype html>
<html lang="en">
<head>
    <title>Quest Test</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/js.js"></script>    
</head>
<body>
    <!-- Спиннер загрузки -->
    <div class="loading">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="container">
<!-- Шапка с формой авторизации --> 
        <nav class="navbar navbar-dark bg-primary">
            <a class="navbar-brand" href="#">Quest Test <span class="logout">(Admin mode)</span></a>
            <form id="login" class="login form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" name="login" placeholder="login" aria-label="Login" required>
                <input class="form-control mr-sm-2" type="password" name="password" placeholder="" aria-label="Passwd" required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">LogIn</button>
            </form>
            <button id="logout" class="btn btn-outline-light my-2 my-sm-0 logout">LogOut</button>
        </nav>
<!-- Таблица задач -->         
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="ord" name="user_name">имя пользователя</th>
                    <th class="ord" name="user_email">email</th>
                    <th>текст задачи</th>
                    <th class="ord" name="action">статус</th>
                </tr>
                <tr class="task">
                    <td>Задач пока нет</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
        </table>
<!-- Пагинация -->        
        <ul class="pagination pagination-sm  justify-content-end">
                <li class="page-item first_page"><a class="page-link" href="#">Первая</a></li>
                <li class="page-item last_page"><a class="page-link" href="#">Последняя</a></li>
        </ul>
<!-- Форма добавления редактирования задачи -->
        <form id="add_task">
            <div class="form-group">
                <label for="user_name">Имя пользователя</label>
                <input id="user_name" type="text" name="user_name" class="form-control"   minlength="3" required>
            </div>
            <div class="form-group">
                <label for="user_email">Email</label>
                <input id="user_email" type="email" name="user_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="user_text">Текст задачи</label>
                <textarea id="user_text" name="user_text" class="form-control" rows="3" minlength="3" required></textarea>
            </div>
            <div class="form-check" style="display:none"><input type="checkbox" class="form-check-input" name="completed" value="yes"> Выполнено</div>
            <input type="submit" class="btn btn-primary" value="Добавить задачу">
            <button class="btn btn-danger">Отменить</button>
        </form>
        

<!-- Модал ответа добавления задачи -->
    <div class="modal fade" id="data_success_modal">
        <div class="modal-dialog">
            <div class="modal-content">       
                <div class="modal-header">
                    <h4 class="modal-title">Задачи</h4>
                    <button type="button" class="close" data-dismiss="modal">X</button>
                </div>            
                <div class="modal-body">
                    Данные сохранены
                </div>            
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>            
            </div>
        </div>
    </div>

    <!-- Модал login success -->
        <div class="modal fade" id="login_success_modal">
            <div class="modal-dialog">
                <div class="modal-content">          
                    <div class="modal-header">
                        <h4 class="modal-title">Авторизация</h4>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                    </div>            
                    <div class="modal-body">
                        Вы успешно авторизовались на сайте.
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>            
                </div>
            </div>
        </div>
    
    <!-- Модал login error -->
        <div class="modal fade" id="login_error_modal">
            <div class="modal-dialog">
                <div class="modal-content">          
                    <div class="modal-header">
                        <h4 class="modal-title">Авторизация</h4>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                    </div>            
                    <div class="modal-body">
                        <span style="color:red">Ошибка авторизации на сайте.</span>
                    </div>            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>            
                </div>
            </div>
        </div>
    
    </div> <!-- /container -->