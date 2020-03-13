document.addEventListener('DOMContentLoaded',function () {

    edit('#edit-email','#form-email','#email-content');
    edit('#edit-uname','#form-uname','#uname-content');



    function edit(button, form, content) {
        $(button).click(function () {
            $(form).toggle();
            $(content).toggle();

            let editBtn = $(`${button} i`);
            if($(editBtn).hasClass('fa-pencil'))
            {
                $(editBtn).removeClass('fa-pencil');
                $(editBtn).addClass('fa-close');
                $(button).removeClass('btn-primary');
                $(button).addClass('btn-secondary');
            }
            else
            {
                $(editBtn).removeClass('fa-close');
                $(editBtn).addClass('fa-pencil');
                $(button).removeClass('btn-secondary');
                $(button).addClass('btn-primary');

            }
        });
    }

});
