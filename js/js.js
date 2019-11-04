const url = "http://tquest.zzz.com.ua/controllers/controller.php";
const tasks_rows = 3;
var offset = 0;
var order_name = 'id';
var order_clause = 'DESC';
var num_page = 1;
var action = 'add';
var edit = false;
var admin = false;
var user_text, user_name, user_email, id;


$(document).ready(function(){

    $.ajax({
        type: "POST",
        url: url,
        data: {action:'is_login'},
        dataType: 'json'
      })
    .done(function(data){
        if (data.login == 'success'){
            admin = true;
            $('.logout').show();
        } else $('.login').show();
        select_tasks();
    });

    

// Login
    login.onsubmit = async (e) => {
        e.preventDefault();
        let formData = new FormData(login);
        $('input[name="password"]').val('');
        formData.append('action','login');
        let response = await fetch(url, {
            method: 'POST',            
            body: formData
        });
        let result = await response.json();
        if (result.login == 'success') {
            admin = true;
            $('.task').addClass('pointer');
            $(login).hide();
            $('.logout').show();
            $("#login_success_modal").modal();
        } else {
            $("#login_error_modal").modal();
        }
    };

// Logout
    $('#logout').on('click', function(){
        $.ajax({
            type: "POST",
            url: url,
            data: {action:'logout'},
            dataType: 'json'
          })
        .done(function(data){
            if (data.logout == 'success'){
                admin = false;
                $('tr.task').removeClass('pointer');
                $('.logout').hide();
                $('#login').show();                
            }    
        });
    });

// Кнопка сброса содержимого формы    
    $('.btn-danger').on('click', function(e){
        e.preventDefault();
        $('input').prop('disabled','');
        $('textarea').html('');
        $('.form-check').hide();
        add_task.reset();
        action = 'add';
        $('.btn-primary').val('Добавить задачу');
    });

// Отправка формы
    add_task.onsubmit = async (e) => {
        e.preventDefault();                
        let formData = new FormData(add_task);
        if(action == 'edit') {
            var new_text = $('textarea[name="user_text"]').val();
            if (user_text == new_text && !edit) action = 'add'; 
            formData.append('id', id);            
            formData.set('user_name', user_name);
            formData.set('user_email', user_email);
        } else {
            num_page = 1;
            offset = 0;
            order_name = 'id';
            order_clause = 'DESC';
        }
            
        formData.append('action', action);
        $('textarea').html('');
        $('.form-check').hide();
        add_task.reset();
        action = 'add';
        $('.btn-primary').val('Добавить задачу');
        $('input').prop('disabled','')
        let response = await fetch(url, {
            method: 'POST',            
            body: formData
        });
        let result = await response.json();
        select_tasks();
        
        if (result.error) {
            admin = false;
            $("#login_error_modal").modal();
            $('.logout').click();
        }
        else  $("#data_success_modal").modal();       
    };

// Выбор страницы в пагинации
    $('body').on('click','.page-item', function () {        
        elm = $(this).get(0);
        var page_id = $(elm).children('a').html();
        if ($(this).hasClass('first_page')) page_id = 1;
        if ($(this).hasClass('last_page')) page_id = $(this).prev().children('a').html();
        num_page = page_id;
        offset = page_id * tasks_rows - tasks_rows;
        select_tasks();        
    });

// Сортировки
    $('body').on('click','.ord', function () {
        $('.ord').css('color','white');
        let elm = $(this).get(0);
        $(elm).css('color','yellow');
        order_name = $(elm).attr('name');
        order_clause = (order_clause == 'DESC') ? 'ASC' : 'DESC';
        select_tasks();
    });

// Выбор задачи на редактирование с занесением в редактор
    $('body').on('click','tr.task', function () {
        let checked = '';
        let elm = $(this).get(0);
        user_name = $(elm).children('.user_name').html();
        user_email = $(elm).children('.user_email').html();
        if (admin && user_name && user_email) {            
            user_text = $(elm).children('.user_text').html();
            edit = ( $(elm).children('.status').hasClass('edit') );
            if ( $(elm).children('.status').hasClass('yes') ) checked = 'checked';                        
            $('.form-check-input').prop('checked',checked);
            id = $(elm).attr('id');

            action = 'edit';
            $('.btn-primary').val('Сохранить изменения');
            $('input[name="user_name"]').val(user_name);
            $('input[name="user_name"]').prop('disabled','disabled');
            $('input[name="user_email"]').val(user_email);
            $('input[name="user_email"]').prop('disabled','disabled');
            $('textarea[name="user_text"]').html(user_text);
            $('.form-check').show(); 
        }     
    });
});

// Выбор задач из БД
async function select_tasks(){
    $('.loading').show();
    let edit_str, completed_str, class_pointer;
    var formData = new FormData();
    formData.append('action', 'select');
    formData.append('order_name', order_name);
    formData.append('order_clause', order_clause);
    formData.append('offset', offset);
    let response = await fetch(url, {
        method: 'POST',            
        body: formData
    });
    let result = await response.json();
    let total = result.total;
    if (total > 0) {
        $('.task').remove();
        class_pointer = (admin) ? 'pointer' : '';
        let tasks_elms = '';
        for(let key in result.tasks){
            edit_str = (result.tasks[key].action == 'edit') ? 'отредактировано администратором' : '';
            completed_str = (result.tasks[key].completed == 'yes') ? 'выполнено' : '';        
            tasks_elms = tasks_elms + `<tr id="${result.tasks[key].id}" class="task ${class_pointer}">
                    <td class="user_name">${result.tasks[key].user_name}</td>
                    <td class="user_email">${result.tasks[key].user_email}</td>
                    <td class="user_text">${result.tasks[key].user_text}</td>
                    <td class="status ${result.tasks[key].action} ${result.tasks[key].completed}">${completed_str}<br />${edit_str}</td>
                </tr>`;
        }
        $(tasks_elms).insertAfter($('thead'));    
        let count_pages = Math.ceil(total / 3);
        let pages_elms = '';
        for(let i = 1; i <= count_pages; i++){
            pages_elms = pages_elms + `<li name="${i}" class="page-item task"><a class="page-link" href="#">${i}</a></li>`;
        }
        $(pages_elms).insertAfter($('.first_page'));
        $('.page-item[name="'+num_page+'"]').addClass('active');
    }
    $('.loading').hide();
}
