function initSimpleMde(fileContent) {
    var simplemde = new global_simplemde({
        element: document.getElementById('editor-md'),
        initialValue: fileContent,
        spellChecker: false,
        showIcons: ["code", "table"],
        shortcuts: {
            'drawTable': "Ctrl-T"
        },
        previewRender: function (plainText) {
            return global_markdown_it.render(plainText); // Returns HTML from a custom parser
        },
    });

    //Add button submit (save) in toolbar
    //var btn = '<button type="submit" class="btn btn-outline-primary"><i class="fal fa-save fa-fw"></i> Save</button>';
    var btn = document.createElement("button");
    btn.type = "submit";
    btn.classList.add("btn", "btn-outline-primary", "float-right");
    btn.style.marginTop = "-3.5px";
    var icone = document.createElement("i");
    icone.classList.add("fal", "fa-save", "fa-fw");
    btn.appendChild(icone);
    btn.appendChild(document.createTextNode(' Save'));
    document.getElementsByClassName('editor-toolbar')[0].appendChild(btn);

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