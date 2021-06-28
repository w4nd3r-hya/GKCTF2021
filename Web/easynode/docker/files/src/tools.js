var mysql = require('mysql');

config = {
    host     : 'localhost',
    user     : 'root',
    password : 'root',
    database : 'test'
}
const select = (sql) =>{
  this.connection = mysql.createConnection(config);
  return new Promise(async (resolve, reject) => {
      this.connection.query(sql, function(err, result,fields) {
      if (err) {
        
        return reject(err)
      };
      
      resolve(result);
    })
  })
  
}

  
const close = ()=>{
          
  return new Promise( ( resolve, reject ) => {
    this.connection.end( err => {
      if ( err )
        return reject(err);
      resolve();
    } );
  } );
}


module.exports = {
  select,
  close
}
      