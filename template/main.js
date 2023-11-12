const id_hide_base = document.getElementById('hide_base');
const table_trading = document.getElementById('table_trading');
const id_base_trade = document.getElementById('base_trade');
const id_if_profit_global = document.getElementById('if_profit_global');
const id_val_shoot = document.getElementById('val_shoot');
const id_val_boom = document.getElementById('val_boom');
const id_chance_min = document.getElementById('chance_min');
const id_chance_max = document.getElementById('chance_max');
const id_profite_session = document.getElementById('profite_session');
const id_marti_win = document.getElementById('marti_win');
const id_marti_los = document.getElementById('marti_los');
const id_if_win_reset = document.getElementById('if_win_reset');
const id_if_los_reset = document.getElementById('if_los_reset');
const id_balance = document.getElementById('balance');
const id_win = document.getElementById('win');
const id_los = document.getElementById('los');
const id_roll = document.getElementById('roll');
const id_profite_global = document.getElementById('profite_global');
const id_socket = document.getElementById('socket');
const id_token = document.getElementById('token');
const id_address = document.getElementById('address');
const id_qrcode = document.getElementById('qrcode');
const id_username = document.getElementById('username');
const id_bonus_reff = document.getElementById('Bonus_reff');
const id_link_reff = document.getElementById('link_reff');
const id_delay = document.getElementById('delay');
const id_coin = document.getElementById('coin');
const id_coin_name = document.getElementById('coin_name');
// composen



//button
const btn_start = document.getElementById('start');
const btn_stop = document.getElementById('stop_on_win');
const btn_shoot = document.getElementById('shoot');
const btn_reset = document.getElementById('reset');
const btn_boom = document.getElementById('boom');
const btn_claim = document.getElementById('claim');
const btn_logout = document.getElementById('logout');

btn_logout.addEventListener("click",(event)=>{
	window.location.href="./logout"
})
id_coin.addEventListener("change",(event)=>{
	id_coin_name.textContent = id_coin.value
	if (id_coin.value != "BITBOT") {
		get_socket(id_coin.value)
	}else{
		id_address.value = ""
		id_qrcode.src = ""
	}
	getSaldo(id_coin.value)
	getBonus(id_coin.value)
})
function getBonus(coin) {
	$.ajax({
		type: "GET",
		url: "./home/getbonus/"+coin,
		success: function(html) {
			id_bonus_reff.value = parseFloat(html).toFixed(8)
		}
	})
}
function getSaldo(coin) {
	$.ajax({
		type: "GET",
		url: "./home/setSado/"+coin,
		success: function(html) {
			id_balance.textContent = parseFloat(html).toFixed(8)
		}
	})
}

function get_socket(coin) {
	const socket = new WebSocket('wss://deltacrypto.biz.id:6969');
	let balance_value = null;
	socket.onopen = function (event) {
	    socket.send(JSON.stringify({method:"balance",token:id_socket.value,coin:coin}));
	    socket.send(JSON.stringify({method:"address",token:id_token.value,coin:coin}));
	};
	socket.onmessage = function (event) {
		var json = JSON.parse(event.data)
		if (json.action == "update_balance") {
			balance_value = json.user_balance
			if (balance_value != null) {
				$.ajax({
	      			type: "POST",
	      			url: "./home/save_deposit",
	      			data: "username=" + id_username.value+"&balance="+balance_value+"&token="+id_token.value+"&coin="+coin,
	      			success: function(html) {
	      			}
	  			})
			}else{
				setTimeout(()=>{
					window.location.href="/"	
				},5000)
				
			}
			
		}
		if (json.address) {
			id_address.value = json.address
			id_qrcode.src = json.qr
		}
		
	}
}

id_link_reff.addEventListener('click', (event) => {
	  id_link_reff.readOnly = true;
 	  id_link_reff.select();
	  try {
	    // Attempt to copy the selected text to the clipboard using the Clipboard API
	    document.execCommand('copy');
	    toastr.success("Link Reff copied to clipboard")
	  } catch (err) {
	    toastr.error('Unable to copy text: ' + err)
	  }
	  id_link_reff.readOnly = false;
	  id_link_reff.setSelectionRange(0, 0);
});

btn_claim.addEventListener("click",(event)=>{
	if (id_bonus_reff.value < 500) {
		toastr.error("Minimum claim 500 TRX")
	}else{
		$.ajax({
			type:"POST",
			url:"./home/claim",
			data:"username="+ id_username.value+"&amount="+id_bonus_reff.value,
			success:function (data) {
				var json = JSON.parse(data);
				if (json.code == 200) {
					toastr.success(json.message)
					setTimeout(()=>{
						window.location.href="./"
					},1000)
				}
			}
		})
	}
})


id_address.addEventListener('click', (event) => {
	  id_address.readOnly = true;
 	  id_address.select();
	  try {
	    // Attempt to copy the selected text to the clipboard using the Clipboard API
	    document.execCommand('copy');
	    toastr.success("Wallet Address copied to clipboard")
	  } catch (err) {
	    toastr.error('Unable to copy text: ' + err)
	  }
	  id_address.readOnly = false;
	  id_address.setSelectionRange(0, 0);
});

btn_start.addEventListener('click', (event) => {
	  id_hide_base.value = id_base_trade.value;
 	  startTrade();
});
function getChance(min,max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min)) + min;
}
let is_trading = true
let is_stop = false;
let status_trade = null;

function startTrade() {
	if (id_base_trade.value > id_balance.textContent) {
 		toastr.error("Your don't have anought balance")
 		return false
 	}
 	if (id_chance_min.value < 20) {
 		toastr.error("Minimun chance 20")
 		return false
 	}
 	if (id_chance_max.value > 95) {
 		toastr.error("Maximum chance 95")
 		return false
 	}
	if (btn_start.textContent === 'Start') {
		btn_start.textContent = 'Stop';
		btn_start.classList.remove('btn-success');
		btn_start.classList.add('btn-danger');
		is_trading = true;
		trading()
	} else {
		btn_start.textContent = 'Start';
		btn_start.classList.remove('btn-danger');
		btn_start.classList.add('btn-success');
		is_trading = false;
		id_win.textContent = 0;
		id_los.textContent = 0;
		id_roll.textContent = 0;
	}
 	
}
let is_win = 0
let is_los = 0
let is_roll = 0
let lastWin = 0;
let lastLos = 0;
function trading() {
	BigNumber.config({ DECIMAL_PLACES: 8 });
	const chance = getChance(id_chance_min.value,id_chance_max.value);
	const actualPayouts = 95 / chance;
	const payout = actualPayouts.toFixed(5);
	let base = parseFloat(id_hide_base.value).toFixed(8)
	const betAmt = new BigNumber(base);
	const actualPayout = new BigNumber(payout);
	const pay = parseFloat(actualPayout.toString()).toFixed(8)
	const bet = parseFloat(betAmt.toString()).toFixed(8)
	const profit = betAmt.times(pay).minus(bet);
	const profits = parseFloat(profit.toString()).toFixed(8)
	const type = getChance(0,1)
	$.ajax({
      type: "POST",
      url: "./home/trading",
      data: "base=" + base+"&chance="+chance+"&profit="+profits+"&type="+type+"&chance="+chance+"&coin="+id_coin.value,
      success: function(html) {
        var jsons = JSON.parse(html);
        var new_profite = parseFloat(id_profite_global.textContent) + parseFloat(jsons.profite);
        id_profite_global.textContent = parseFloat(new_profite).toFixed(8)
        if (id_if_profit_global.value > 0) {
        	if (id_if_profit_global.value <= id_profite_global.textContent) {
        		toastr.success("Global profit target achieved")
        		btn_start.textContent = 'Start';
						btn_start.classList.remove('btn-danger');
						btn_start.classList.add('btn-success');
						is_trading = false;
        	}
        }
        var newBalance = parseFloat(id_balance.textContent) + parseFloat(jsons.profite);
        id_balance.textContent = parseFloat(newBalance).toFixed(8)
        if (id_balance.textContent < jsons.profite) {
        	toastr.error("Your don't have anought balance")
        	btn_start.textContent = 'Start';
					btn_start.classList.remove('btn-danger');
					btn_start.classList.add('btn-success');
					is_trading = false;
        }
        if (id_profite_global.textContent >= id_profite_session.value) {
			    	id_hide_base.value = id_base_trade.value
		    }else{
		    	id_hide_base.value = parseFloat(newBase).toFixed(8)	
		    }
        const newRow = document.createElement('tr');
        const cell1 = document.createElement('td');
        const cell2 = document.createElement('td');
        const cell3 = document.createElement('td');
        if (jsons.status == 1) {
        	status_trade = "win"
        	newRow.classList.add('bg-success');
        	is_win++;
        	lastWin = Math.max(lastWin, is_win);
        	is_los = 0;
        	var newBase = ((id_marti_win.value*parseFloat(jsons.base))/100)+parseFloat(jsons.base)
        	if (id_if_win_reset == 0) {
        		id_hide_base.value = newBase
        	}else{
        		if (is_win <= if_win_reset.value) {
				    	id_hide_base.value = id_base_trade.value
	        	}else{
	        		
	        		id_hide_base.value =newBase
	        	}
        	}
        	id_roll.classList.remove('bg-danger');
        	id_roll.classList.add('bg-success');
        	id_roll.textContent = is_win
        	if (is_stop) {
        		is_win = 0
        		is_win = 0
        		btn_start.textContent = 'Start';
						btn_start.classList.remove('btn-danger');
						btn_start.classList.add('btn-success');
						is_trading = false;
        	}
        }else{
        	status_trade = "los"
        	newRow.classList.add('bg-danger');
        	var newBase = ((id_marti_los.value*parseFloat(jsons.base))/100)+parseFloat(jsons.base)
        	
        	is_win= 0;
        	is_los++;
        	if (id_if_los_reset == 0) {
        		id_hide_base.value = newBase
        	}else{
        		if (is_los <= id_if_los_reset.value) {
				    	id_hide_base.value = id_base_trade.value
	        	}else{
	        		id_hide_base.value = newBase
	        	}
        	}
        	
        	
        	id_roll.classList.remove('bg-success');
        	id_roll.classList.add('bg-danger');
        	id_roll.textContent = is_los
        	lastLos = Math.max(lastLos, is_los);
        }
        if (trading) {
        	id_los.textContent= lastLos	
        	id_win.textContent= lastWin	
        }else{
        	id_win.textContent = 0;
					id_los.textContent = 0;
					id_roll.textContent = 0;
        }
        
       
        
        cell1.textContent = jsons.type;
        newRow.appendChild(cell1);
        cell2.textContent = jsons.base;
        newRow.appendChild(cell2);
        cell3.textContent = jsons.profite;
        newRow.appendChild(cell3);
        const firstRow = table_trading.firstChild;
        table_trading.insertBefore(newRow,firstRow);
        if (is_trading) {
	 		setTimeout(()=>{
	 			if (is_trading) {
	 				trading()	
	 			}
	 		},id_delay.value)
 		}
 		

      }
    });
}
console.log(is_win,is_los)

btn_stop.addEventListener("click",(event)=>{
	is_stop = true
})
btn_shoot.addEventListener("click",(event)=>{
	if (id_balance.textContent > id_val_shoot.value) {
		id_hide_base.value = id_val_shoot.value
	}else{
		toastr.error("You Dont have anought balance")
	}
	
})
btn_reset.addEventListener("click",(event)=>{
	id_hide_base.value = id_base_trade.value
})
btn_boom.addEventListener("click",(event)=>{
	if (id_balance.textContent > id_val_boom.value) {
		id_hide_base.value = id_val_boom.value	
	}else{
		toastr.error("You Dont have anought balance")
	}
	
})