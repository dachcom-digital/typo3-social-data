define([], function() {
    "use strict";
    class ConnectWindow {
        constructor(connectUrl, onSuccess, onError, onClose) {
            this.connectUrl = connectUrl;
            this.onSuccess = onSuccess;
            this.onError = onError;
            this.onClose = onClose;
            this.stateData = null;

            this._connectWindow = null;
            this._connectTimer = null;
        }

        open() {

            let windowSize, windowLocation, features;

            windowSize = {
                width: 960,
                height: 680,
            };

            windowLocation = {
                left: ((window.screenLeft ? window.screenLeft : window.screenX) + (window.innerWidth / 2)) - (windowSize.width / 2),
                top: ((window.screenTop ? window.screenTop : window.screenY) + (window.screen.availHeight / 2)) - (window.innerHeight / 2)
            };

            features = [
                'toolbar=1',
                'location=1',
                'width=' + windowSize.width,
                'height=' + windowSize.height,
                'left=' + windowLocation.left,
                'top=' + windowLocation.top,
            ];

            this._connectWindow = window.open(window.location.origin + this.connectUrl, 'LoginWindow', features.join(','));
            this._connectTimer = setInterval(this._checkConnectWindowClosure.bind(this), 500);
        }

        _checkConnectWindowClosure() {
            var stateElement,
                popupDocument;

            if (!this._connectWindow) {
                return;
            }

            if (this.stateData !== null) {

                this._connectWindow.close();

                clearInterval(this._connectTimer);

                if (this.stateData.error === true) {

                    if (typeof this.onError == 'function') {
                        this.onError(this.stateData);
                    }

                    return;
                }

                if (typeof this.onSuccess == 'function') {
                    this.onSuccess(this.stateData);
                }

                return;

            } else if (this._connectWindow.closed) {

                clearInterval(this._connectTimer);

                if (typeof this.onClose == 'function') {
                    this.onClose();
                }

                return;
            }

            try {
                popupDocument = this._connectWindow.document;
            } catch (error) {
                return;
            }

            if (popupDocument.domain !== document.domain) {
                return;
            }

            try {
                stateElement = popupDocument.getElementById('connect-response');
            } catch (error) {
                return;
            }

            if (stateElement) {
                this.stateData = JSON.parse(stateElement.value);
            }
        }
    }
    return ConnectWindow;
});
