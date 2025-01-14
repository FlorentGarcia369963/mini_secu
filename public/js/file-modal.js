function openModal(button) {
    const filePath = button.getAttribute("data-filename");
    const fileType = button.getAttribute("data-file-type");
    console.log(filePath);
    const iframe = document.getElementById("fileViewer");
    const filename = filePath.split("/").at(-1);
    console.log(filename);

    iframe.src = `/secure-file/${fileType}/${filename}`;
    const modal = new bootstrap.Modal(document.getElementById("fileModal"));
    modal.show();
}

function handleClick(button) {
    console.log(button);
    const requestId = button.getAttribute("data-requestId");
    const action = button.getAttribute("data-action");

    console.log(action);
    console.log(requestId);
    const form = document.getElementById("advisor-request-form");
    form.querySelector("#input-id").value = requestId;
    form.querySelector("#actionField").value = action;

    form.submit();
}
