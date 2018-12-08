<script>

     function onReadyRename(btnName,url,type) {
         let cleanUrl = url;
        $(`button[id^=${btnName}]`).click(function (event) {
            let id = $(this).val();
            let url = cleanUrl.replace(":id",id);
            let innerText="";
            if(type=="current"){
                innerText = $('#currentFolder').text();
            }else{
                innerText = $(`.${type}${id}`).text();
            }

            event.preventDefault();
            swal({
                title: `Rename ${type}: " ${innerText} "`,
                input: 'text',
                inputValue: innerText,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Rename',
                showLoaderOnConfirm: true,
                preConfirm: (Name) => {
                    return fetch(url, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        body: JSON.stringify({newName: Name})
                    }).then(response => {
                        let rep = response.json();
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        rep.then(result =>{
                            if(result.state==false){
                                swal.showValidationMessage(
                                    `Name already exists: ${result.newName}`
                                )
                            }
                        })
                        return rep;
                    })
                        .catch(error => {
                            swal.showValidationMessage(
                                `Request failed: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !swal.isLoading()
            }).then((result) => {
                if (result.value.state) {
                    swal(
                        `${type} Rename`,
                        `${result.value.newName}`,
                        'success'
                    ).then(function () {
                        //location.reload();
                        if(type=="current"){
                            $('#currentFolder').text(result.value.newName);
                        }else{
                            $(`.${type}${id}`).text(result.value.newName);
                        }

                    });
                }else {
                    throw new Error(`Name already exist: ${result.value.newName}`);
                }


            })

        })
    }
</script>