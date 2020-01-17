let http_https = "https";

let url = window.location.href;
let http_https_control = url.split("://")[0];
if (http_https_control && (http_https_control == 'http' || http_https_control == 'https')) {
	http_https = http_https_control;
}

url = http_https + "://localhost:8080/TecWeb/";