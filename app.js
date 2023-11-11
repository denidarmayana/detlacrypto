const Web3 = require('web3');
const axios = require('axios'); // Import axios library
const web3 = new Web3('https://bsc-dataseed.binance.org/');

var apiKey = "EHQ9KCR86R2BZPI63SHY2CBZDJQ6WQZJ4X";
var contract = "0x4d8EDCA96E6eaC9b987c88A179cC580BF75e8462";

axios.get('https://api.bscscan.com/api', {
    params: {
        module: 'token',
        action: 'tokeninfo',
        contractaddress: contract,
        apikey: apiKey
    }
})
.then(function (response) {
   console.log(response.data)
})
.catch(function (error) {
    console.error("Error fetching ABI:", error);
});
