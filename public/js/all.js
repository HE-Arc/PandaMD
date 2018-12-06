function initSimpleMde(fileContent) {
    var simplemde = new global_simplemde({
        element: document.getElementById('editor-md'),
        initialValue: fileContent,
        spellChecker: false,
        showIcons: ["code", "table"],
        previewRender: function (plainText) {
            return global_markdown_it.render(plainText); // Returns HTML from a custom parser
        },
    });

    //Add button submit (save) in toolbar
    //Button md lg
    var btn = document.createElement("button");
    btn.type = "submit";
    btn.classList.add("btn", "btn-outline-primary", "float-md-right");
    btn.style.marginTop = "-3.5px";
    var icone = document.createElement("i");
    icone.classList.add("fal", "fa-save", "fa-fw");
    btn.appendChild(icone);
    var spanSaveText = document.createElement("span");
    spanSaveText.classList.add("d-none", "d-md-inline");
    spanSaveText.appendChild(document.createTextNode(' Save'));
    btn.appendChild(spanSaveText);
    document.getElementsByClassName('editor-toolbar')[0].appendChild(btn);

    var cancelLink = document.createElement("button");
    cancelLink.addEventListener("click", function () {
        location.href = cancelUrl;
    });
    cancelLink.type="button";
    cancelLink.style.marginTop = "-3.5px";
    cancelLink.classList.add("btn", "btn-outline-danger", "float-md-right", "mr-1");
    var icone = document.createElement("i");
    icone.classList.add("fal", "fa-times-octagon", "fa-fw");
    cancelLink.appendChild(icone);
    spanSaveText = document.createElement("span");
    spanSaveText.appendChild(document.createTextNode(' Cancel'));
    cancelLink.appendChild(spanSaveText);
    document.getElementsByClassName('editor-toolbar')[0].appendChild(cancelLink);

    /* Sticky the toolbar of simplemde
      * Source : https://www.w3schools.com/howto/howto_js_navbar_sticky.asp */
    window.onscroll = function () {
        stickymde()
    };
    var toolbar = document.getElementsByClassName('editor-toolbar')[0];
    var sticky = toolbar.offsetTop;

    function stickymde() {
        if (window.pageYOffset >= sticky) {
            toolbar.classList.add("sticky");
        } else {
            toolbar.classList.remove("sticky");
        }
    }
}

function renderMarkdown(plaintext) {
    return global_markdown_it.render(plaintext);
}