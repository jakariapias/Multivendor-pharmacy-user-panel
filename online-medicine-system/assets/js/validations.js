const validateEmail=(email)=>{
    if(email!=='')
    {
        // eslint-disable-next-line no-useless-escape
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase())
    }
    return true
    
}
const validatePass=(pass)=>{
    let regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[@#$%!^&*+=\-\[\]\\';,/{}|\\":<>\?()])(?=.*[0-9])[A-Za-z@#$%!^&*+=\-\[\]\\';,/{}|\\":<>\?()0-9]{8,}$/;
    if(pass!==""){
        checkPassMatch(pass,'')
      return {
        passLengthValid:pass.length>8,
        passValid:regex.test(pass)
      }
      
    }
    return {passLengthValid:true,passValid:true}
}
