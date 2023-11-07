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
const id_balance = document.getElementById('balance');
const id_win = document.getElementById('win');
const id_los = document.getElementById('los');
const id_roll = document.getElementById('roll');
const id_profite_global = document.getElementById('profite_global');
const id_socket = document.getElementById('socket');
const id_token = document.getElementById('token');
const id_address = document.getElementById('address');
const id_qrcode = document.getElementById('qrcode');
// composen

//button
const btn_start = document.getElementById('start');
const btn_stop = document.getElementById('stop_on_win');
const btn_shoot = document.getElementById('shoot');
const btn_reset = document.getElementById('reset');
const btn_boom = document.getElementById('boom');

const socket = new WebSocket('ws://deltacrypto.biz.id:6969');
socket.onopen = function (event) {
	console.log("SOCKET TERBUKA")
    socket.send(JSON.stringify({method:"balance",token:id_socket.value,coin:"TRX"}));
    socket.send(JSON.stringify({method:"address",token:id_token.value,coin:"TRX"}));
};
socket.onmessage = function (event) {
	console.log(event.data)
	var json = JSON.parse(event.data)
	if (json.action == "update_balance") {
		id_balance.textContent = json.user_balance
	}
	if (json.address) {
		id_address.value = json.address
		id_qrcode.src = json.qr
	}
}
id_address.addEventListener('click', (event) => {
	  id_address.readOnly = true;
 	  id_address.select();
	  try {
	    // Attempt to copy the selected text to the clipboard using the Clipboard API
	    document.execCommand('copy');
	    toastr.success("Text copied to clipboard")
	  } catch (err) {
	    toastr.error('Unable to copy text: ' + err)
	  }
	  id_address.readOnly = false;
	  id_address.setSelectionRange(0, 0);
});

btn_start.addEventListener('click', (event) => {
 	  startTrade();
});
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
}

// if (btn_start.textContent === 'Start') {
// 	btn_start.textContent = 'Stop';
// 	btn_start.classList.remove('btn-success');
// 	btn_start.classList.add('btn-danger');
// 	console.log('PLAY');
// } else {
// 	btn_start.textContent = 'Start';
// 	btn_start.classList.remove('btn-danger');
// 	btn_start.classList.add('btn-success');
// 	console.log('stop');
// }