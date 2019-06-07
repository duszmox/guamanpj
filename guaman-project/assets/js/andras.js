
async function fun() {
    const {value: title} = await Swal.fire({
        title: 'Enter title',
        input: 'text',
        inputPlaceholder: 'Enter Title',
        inputAttributes: {
            maxlength: 10,
            autocapitalize: 'off',
            autocorrect: 'off'
        }
    }).then(function () {
        const {value: content} =  Swal.fire({
            title: 'Enter Content',
            input: 'textarea',

            inputPlaceholder: 'Enter Content',
            inputAttributes: {

                autocapitalize: 'off',
                autocorrect: 'off'
            }
        })
    });


    if (title && content) {
        Swal.fire('Entered title: ' + title).then(function(){
            Swal.fire('Entered Content : ' + content);
        });

    }
}

fun();
