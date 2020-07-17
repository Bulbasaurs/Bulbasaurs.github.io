 let mobileNav = document.getElementById('mobile-nav');
 
 mobileNav.addEventListener('click', function() {
 	if (this.style.height == '100vh') {
 		this.style.height = '1cm';
 		mobileNav.lastElementChild.style.display="none";
 	} else {
 		this.style.height = '100vh';
 		mobileNav.lastElementChild.style.display="block";
 	}
 })
 
 
// let sb = document.querySelector('.sb')
// let listItems = sb.getElementsByTagName('li')
 
// for (let i = 0; i < listItems.length; i++) {
// 	listItems[i].addEventListener('click', function() {
// 		let p = document.createElement('p')
// 		// p.textContent = this.textContent
// 		p.appendChild(document.createTextNode(this.textContent));
// 		document.getElementsByTagName('main')[0].appendChild(p)
// 	})
// } 
 /*THIS CODE ADDS A PARAGRAPH DO NOT USE :-) */
 
 // document.getElementsByClassName('xx')
 // document.querySelectorAll('.xx')
 
// document.getElementById('thebutton').addEventListener('click', function() {
// 	let name = document.querySelector('#user_name').value
// 	let checked = document.getElementById('thecheckbox').checked
// 	let word = document.querySelector('#thedropdown').value
// 	
// 	alert(word + ' ' + name + ' ' + checked);
// })
//

 let load = document.getElementById('onloadinfo');
 load.onload{
load.style.display = block;
 }

 document.onload.load.style.display = block;

 //^^^^ this is meant to show the element 'onloadinfo' when the page loads but it's not working yet!