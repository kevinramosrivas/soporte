let allFilePDICON = document.querySelectorAll('.file-pdf-icon');
let allFilePDFEmbed = document.querySelectorAll('.file-pdf-embed');

//detectar el cliente si es mobile o desktop
let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);


if (isMobile) {

    //remover el embed del DOM
    allFilePDFEmbed.forEach((embed) => {
        embed.remove();
    }
    );

} 
else {
    //remover el icon del DOM
    allFilePDICON.forEach((icon) => {
        icon.remove();
    }
    );

}