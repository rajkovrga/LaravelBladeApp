document.addEventListener('DOMContentLoaded',function () {

    edit('#edit-email','#form-email','#email-content');
    edit('#edit-uname','#form-uname','#uname-content');



    function edit(button, form, content) {
        $(button).click(() => {
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

    let imageEditButton = document.getElementById('image-input');
    let errorImage = document.getElementById("error-image");

    imageEditButton.addEventListener('change',  () => {
        errorImage.innerText = '';
        if(!this.files[0].type.match(/.(jpg|jpeg|png|gif)$/i))
        {
            errorImage.innerText = 'Fajl nije u dobrom formatu';
            return;
        }

        let formData = new FormData();
        formData.append(this.files[0]);

        axios.post('/change/image',{data: formData})
            .then(result => {
                document.getElementById('iamge-avatar').src = result;
            })
            .catch(error => {
                if(error.status == 500)
                    errorImage.innerText = 'Doslo je do greske';
            });

    });

});
