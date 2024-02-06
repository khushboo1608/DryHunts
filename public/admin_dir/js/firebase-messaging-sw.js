importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js');
// For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics. 
importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-analytics.js');
importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-auth.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
// firebase.initializeApp({
//   messagingSenderId: '688131500696'
// });
firebase.initializeApp({
  apiKey: "AIzaSyBzW6oaNiZ2CM6ct7hmRtp9EyI8Pv1qFNU",
  authDomain: "rise-323105.firebaseapp.com",
  databaseURL: "https://rise-323105-default-rtdb.firebaseio.com",
  projectId: "rise-323105",
  storageBucket: "rise-323105.appspot.com",
  messagingSenderId: "688131500696",
  appId: "1:688131500696:web:0d29d995d83e474dcebeed",
  measurementId: "G-DSYSJCEDNJ"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/itwonders-web-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});