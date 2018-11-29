<script>

    function OnreadyChangeFolder() {

        let url = "{{route('changeFolderId',':id')}}";

        $("a[id^='folder']").on('click',function () {
            let fileId=$(this).attr('name');
            url = url.replace(":id", fileId);
            //change clicked folder to bold and selected icon
            let newFolderId = $(this).attr('value');
            let newMarkedText = $(this).text();
            let oldMarkedLink=$(".font-weight-bold").parent()
            let oldMarkedText=$(".font-weight-bold").text();
            let stringUnSelected=`<i class="fal fa-folder fa-fw"></i> ${oldMarkedText}`
            let stringSelected =`<span class="font-weight-bold" ><i class="fas fa-folder"></i> ${newMarkedText} <i
        class="far fa-check"></i></span>`
            $(this).html(stringSelected);
            oldMarkedLink.html(stringUnSelected);

            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({newFolderId: newFolderId})
            }).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }

            })
                .catch(error => {
                    console.log(error);
                    swal({
                        type: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again',
                    })
                })
        });


    }
</script>
