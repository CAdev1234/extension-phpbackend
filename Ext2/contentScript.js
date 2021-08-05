// chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
//     if (request.type === 'getting_site_url') {
//         chrome.runtime.sendMessage({type: 'send_site_url', site_url: window.location.hostname})
//     }
//     sendResponse({
//         response: 'Message received'
//     })
//     return true
// })

(function() {
    var obj_var = {}
    obj_var.site_url = window.location.hostname
    return obj_var
})();