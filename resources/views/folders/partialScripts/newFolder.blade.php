<script>
    var onReadyNewFolder = function () {
        $('#btnNewFolder').click(function (event) {
            event.preventDefault()
            swal({
                title: 'Rename your new Folder',
                input: 'text',
                inputValue: 'Untilted',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Create',
                showLoaderOnConfirm: true,
                preConfirm: (folderName) => {
                    return fetch('{{route('folders.store')}}', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        body: JSON.stringify({name: folderName, folderId: "{{$folder->id}}"})
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        let rep = response.json();
                        rep.then(result =>{
                            if(result.state==false){
                                swal.showValidationMessage(
                                    `Folder already exists: ${result.name}`
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
                        'Folder Created',
                        `${result.value.name}`,
                        'success'
                    ).then(function () {
                        location.reload();
                    });
                } else {
                    throw new Error(`Name already exist: ${result.value.name}`);
                }


            })
        })
    }
</script>