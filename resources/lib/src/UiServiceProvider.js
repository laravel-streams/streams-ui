import {
    ServiceProvider
} from '@streams/core';

export class UiServiceProvider extends ServiceProvider {

    boot() {

        // window.streams.core.app.surfaces = function () {
        //     return {

        //         content: '',
        //         enabled: false,

        //         enableSurfaces() {

        //             this.enabled = true;

        //             return this;
        //         },

        //         disableSurfaces() {

        //             this.enabled = false;

        //             return this;
        //         },

        //         loadSurface(params) {

        //             if (!this.enabled) {
        //                 this.enableSurfaces();
        //             }

        //             // Check if target is a selector
        //             if (params.target.includes('#') || params.target.includes('.')) {

        //                 this.content = document.querySelector(params.target).innerHTML;

        //                 return;

        //             } else {

        //                 window.streams.core.axios.get(params.target).then((response) => {
        //                     this.content = response.data;
        //                 });

        //                 return;
        //             }
        //         }
        //     };
        // }
    }
}
