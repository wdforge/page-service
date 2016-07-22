var app = function testApp(config) {
    // метод безопасного запуска
	var execute = function(method, config) {
		var runMethod = function() {
			if(typeof config.timeout == "undefined") {
				config.timeout = 10;
			}

			var interval = setInterval(function() {
				try {
					method();
				} 
				catch (e) {};

				if (typeof config.started != "undefined" && config.started) {
					clearInterval(interval);
				}
			}, params.timeout);
		}

		if (document.readyState == "complete" || document.readyState == "interactive") {
	    	return this.runMethod();
		}

		if(document.addEventListener) {
			if (typeof config.started == "undefined") {
				config.started = false;
			}

			document.addEventListener("DOMContentLoaded", function () { 
				return this.runMethod();
			});
		} 
		else {
			if (typeof config.started == "undefined") {
				config.started = false;
			}


			return document.attachEvent('onreadystatechange', method);
		}
	}
    
    // метод проверки совместимости
	var ishtml5 = function() {
		try {
			HTMLCanvasElement;
			return true;
		} catch (e) {
			return false;
		};
	}

    // метод начальной инициализации
	var run = function(config= []) {
		if(this.ishtml5()) {
			parent.execute(this.getAction(), config);
		}
		else{
			alert('html5 not supported');
		}
	}
};
