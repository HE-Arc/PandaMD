<script>

    var onReadyRename = function () {
        $("button[id^='btnRenameFolder']").click(function (event) {
            let value = $(this).val();
            let id = $(this).attr("name");
            let that = $(event.currentTarget);
            event.preventDefault();
            swal({
                title: 'Rename Folder: "' + value + '"',
                input: 'text',
                inputValue: value,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Rename',
                showLoaderOnConfirm: true,
                preConfirm: (folderName) => {
                    return fetch(`{{url('/folders')}}/${id}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        body: JSON.stringify({newName: folderName})
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        let rep = response.json();
                        rep.then(result =>{
                            if(result.state==false){
                                swal.showValidationMessage(
                                    'Name already exists'
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
                swal(
                    'Folder Rename',
                    `${result.value.newName}`,
                    'success'
                ).then(function () {
                    //location.reload();
                    that.parents('a').children('h3').children('span').text(result.value.newName);
                });

            })

        })
    }
</script>