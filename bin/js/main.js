// function process(){
//     const img = $("#qrCode"),
//     input = $("input"),
//     form_data = new FormData();

//     for(let i = 0; i < input.length; i++){
//         form_data.append(input[i].name, input[i].value);
//     }

//     fetch("bin/process.php", {
//         method : "POST",
//         body : form_data
//     })
//     .then(r=>r.blob())
//     .then(e=>{
//         const reader = new FileReader();
//         reader.readAsDataURL(e);
//         reader.onloadend = ()=> img.attr("src", reader.result);
//     });
// }