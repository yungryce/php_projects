function copyToClipboard(id) {
    const codeBlock = document.getElementById(id);
    const codeText = codeBlock.innerText;

    const textarea = document.createElement('textarea');
    textarea.value = codeText;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    alert('Code copied to clipboard!');
}



// function copyToClipboard(id) {
//     const codeBlock = document.getElementById(id);
//     const codeText = codeBlock.innerText;
//     codeText.setSelectionRange(0, 99999);

//     navigator.clipboard.writeText(codeText)
//         .then(() => {
//             alert('Code copied to clipboard!');
//         })
//         .catch((err) => {
//             console.error('Unable to copy to clipboard', err);
//         });
// }



// async function copyToClipboard(id) {
//     const codeBlock = document.getElementById(id);
//     const codeText = codeBlock.innerText;
//     console.log(codeText);
//     try {
//         await navigator.clipboard.writeText(codeText);
//     } catch (error) {
//         console.error(error.message);
//     }
// }