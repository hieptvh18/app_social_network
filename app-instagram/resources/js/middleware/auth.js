// import {getUser} from '../api/auth';
// import axios from 'axios';

// export default function checkLogin({next, router}){
//     let currentToken = window.localStorage.getItem('tokenLogin');

//     if(currentToken){
//         // get user check token expired => next request or fail request
//         const headers = {
//             headers:{
//                 'Content-Transfer-Encoding': 'application/json',
//                 'content-type': 'application/json',
//                 'Authorization': currentToken,
//             }
//         }
//         axios({
//             url:'',
//             method:'GET',
//             headers: headers
//         }).then(response => {
//             console.log(response);
//             if(response.message == 'Unauthenticated'){
//                 window.location.href = '/accounts/login';
//             }
//         }).catch(error => {
//             console.log(error)
//             window.location.href = '/accounts/login';
//         })
//     }
// }

export default function auth({ next, router }) {
    console.log('mdw');
    if (!localStorage.getItem('tokenLogin')) {
      return router.push({ name: 'login' });
    }
  
    return next();
  }

//   export default function guest({next,store}){
//     let isLoggedIn = false // Can be calculated through store
//     if(isLoggedIn){
//         return next({
//             name: 'home'
//         })
//     }
 
//     return next();
//  }