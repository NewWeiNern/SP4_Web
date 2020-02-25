const interval = 2000;
let Interval;
class JSBin{
    mode = "idle";
    constructor(){
        Interval = setInterval(()=>this.init(), interval);
    }
    async getJson(e,callback){
        if(!callback){
            callback = e=>e;
        }
        return e.json().then(callback);
    }
    async init(){
        let xml = new XMLHttpRequest();
        let formdata = new FormData();
        let request_init = {method : "POST", body : formdata};
        formdata.append("code", code);

        switch(this.mode){
            case "idle" : 
                fetch("bin/idle.php", request_init).then(async e=>{
                    const json = await this.getJson(e);
                    if(json.is_scanned == 1){this.mode = "open";}
                });
            break;
            case "open" : 
                
            break;
        }
    }
}