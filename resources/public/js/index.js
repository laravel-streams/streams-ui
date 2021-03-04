(()=>{var e={443:function(e){e.exports=function(){"use strict";function e(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function t(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function n(n){for(var i=1;i<arguments.length;i++){var r=null!=arguments[i]?arguments[i]:{};i%2?t(Object(r),!0).forEach((function(t){e(n,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(n,Object.getOwnPropertyDescriptors(r)):t(Object(r)).forEach((function(e){Object.defineProperty(n,e,Object.getOwnPropertyDescriptor(r,e))}))}return n}function i(){return new Promise((e=>{"loading"==document.readyState?document.addEventListener("DOMContentLoaded",e):e()}))}function r(e){return Array.from(new Set(e))}function o(){return navigator.userAgent.includes("Node.js")||navigator.userAgent.includes("jsdom")}function s(e,t){return e==t}function a(e,t){"template"!==e.tagName.toLowerCase()?console.warn(`Alpine: [${t}] directive should only be added to <template> tags. See https://github.com/alpinejs/alpine#${t}`):1!==e.content.childElementCount&&console.warn(`Alpine: <template> tag with [${t}] encountered with an unexpected number of root elements. Make sure <template> has a single root element. `)}function l(e){return e.replace(/([a-z])([A-Z])/g,"$1-$2").replace(/[_\s]/,"-").toLowerCase()}function c(e){return e.toLowerCase().replace(/-(\w)/g,((e,t)=>t.toUpperCase()))}function u(e,t){if(!1===t(e))return;let n=e.firstElementChild;for(;n;)u(n,t),n=n.nextElementSibling}function f(e,t){var n;return function(){var i=this,r=arguments,o=function(){n=null,e.apply(i,r)};clearTimeout(n),n=setTimeout(o,t)}}const d=(e,t,n)=>{if(console.warn(`Alpine Error: "${n}"\n\nExpression: "${t}"\nElement:`,e),!o())throw Object.assign(n,{el:e,expression:t}),n};function p(e,{el:t,expression:n}){try{const i=e();return i instanceof Promise?i.catch((e=>d(t,n,e))):i}catch(e){d(t,n,e)}}function h(e,t,n,i={}){return p((()=>"function"==typeof t?t.call(n):new Function(["$data",...Object.keys(i)],`var __alpine_result; with($data) { __alpine_result = ${t} }; return __alpine_result`)(n,...Object.values(i))),{el:e,expression:t})}function m(e,t,n,i={}){return p((()=>{if("function"==typeof t)return Promise.resolve(t.call(n,i.$event));let e=Function;if(e=Object.getPrototypeOf((async function(){})).constructor,Object.keys(n).includes(t)){let e=new Function(["dataContext",...Object.keys(i)],`with(dataContext) { return ${t} }`)(n,...Object.values(i));return"function"==typeof e?Promise.resolve(e.call(n,i.$event)):Promise.resolve()}return Promise.resolve(new e(["dataContext",...Object.keys(i)],`with(dataContext) { ${t} }`)(n,...Object.values(i)))}),{el:e,expression:t})}const y=/^x-(on|bind|data|text|html|model|if|for|show|cloak|transition|ref|spread)\b/;function v(e){const t=w(e.name);return y.test(t)}function b(e,t,n){let i=Array.from(e.attributes).filter(v).map(x),r=i.filter((e=>"spread"===e.type))[0];if(r){let n=h(e,r.expression,t.$data);i=i.concat(Object.entries(n).map((([e,t])=>x({name:e,value:t}))))}return n?i.filter((e=>e.type===n)):g(i)}function g(e){let t=["bind","model","show","catch-all"];return e.sort(((e,n)=>{let i=-1===t.indexOf(e.type)?"catch-all":e.type,r=-1===t.indexOf(n.type)?"catch-all":n.type;return t.indexOf(i)-t.indexOf(r)}))}function x({name:e,value:t}){const n=w(e),i=n.match(y),r=n.match(/:([a-zA-Z0-9\-:]+)/),o=n.match(/\.[^.\]]+(?=[^\]]*$)/g)||[];return{type:i?i[1]:null,value:r?r[1]:null,modifiers:o.map((e=>e.replace(".",""))),expression:t}}function _(e){return["disabled","checked","required","readonly","hidden","open","selected","autofocus","itemscope","multiple","novalidate","allowfullscreen","allowpaymentrequest","formnovalidate","autoplay","controls","loop","muted","playsinline","default","ismap","reversed","async","defer","nomodule"].includes(e)}function w(e){return e.startsWith("@")?e.replace("@","x-on:"):e.startsWith(":")?e.replace(":","x-bind:"):e}function k(e,t=Boolean){return e.split(" ").filter(t)}const E="in",O="out",S="cancelled";function P(e,t,n,i,r=!1){if(r)return t();if(e.__x_transition&&e.__x_transition.type===E)return;const o=b(e,i,"transition"),s=b(e,i,"show")[0];if(s&&s.modifiers.includes("transition")){let i=s.modifiers;if(i.includes("out")&&!i.includes("in"))return t();const r=i.includes("in")&&i.includes("out");i=r?i.filter(((e,t)=>t<i.indexOf("out"))):i,$(e,i,t,n)}else o.some((e=>["enter","enter-start","enter-end"].includes(e.value)))?N(e,i,o,t,n):t()}function A(e,t,n,i,r=!1){if(r)return t();if(e.__x_transition&&e.__x_transition.type===O)return;const o=b(e,i,"transition"),s=b(e,i,"show")[0];if(s&&s.modifiers.includes("transition")){let i=s.modifiers;if(i.includes("in")&&!i.includes("out"))return t();const r=i.includes("in")&&i.includes("out");i=r?i.filter(((e,t)=>t>i.indexOf("out"))):i,C(e,i,r,t,n)}else o.some((e=>["leave","leave-start","leave-end"].includes(e.value)))?L(e,i,o,t,n):t()}function $(e,t,n,i){T(e,t,n,(()=>{}),i,{duration:j(t,"duration",150),origin:j(t,"origin","center"),first:{opacity:0,scale:j(t,"scale",95)},second:{opacity:1,scale:100}},E)}function C(e,t,n,i,r){T(e,t,(()=>{}),i,r,{duration:n?j(t,"duration",150):j(t,"duration",150)/2,origin:j(t,"origin","center"),first:{opacity:1,scale:100},second:{opacity:0,scale:j(t,"scale",95)}},O)}function j(e,t,n){if(-1===e.indexOf(t))return n;const i=e[e.indexOf(t)+1];if(!i)return n;if("scale"===t&&!M(i))return n;if("duration"===t){let e=i.match(/([0-9]+)ms/);if(e)return e[1]}return"origin"===t&&["top","right","left","center","bottom"].includes(e[e.indexOf(t)+2])?[i,e[e.indexOf(t)+2]].join(" "):i}function T(e,t,n,i,r,o,s){e.__x_transition&&e.__x_transition.cancel&&e.__x_transition.cancel();const a=e.style.opacity,l=e.style.transform,c=e.style.transformOrigin,u=!t.includes("opacity")&&!t.includes("scale"),f=u||t.includes("opacity"),d=u||t.includes("scale"),p={start(){f&&(e.style.opacity=o.first.opacity),d&&(e.style.transform=`scale(${o.first.scale/100})`)},during(){d&&(e.style.transformOrigin=o.origin),e.style.transitionProperty=[f?"opacity":"",d?"transform":""].join(" ").trim(),e.style.transitionDuration=o.duration/1e3+"s",e.style.transitionTimingFunction="cubic-bezier(0.4, 0.0, 0.2, 1)"},show(){n()},end(){f&&(e.style.opacity=o.second.opacity),d&&(e.style.transform=`scale(${o.second.scale/100})`)},hide(){i()},cleanup(){f&&(e.style.opacity=a),d&&(e.style.transform=l),d&&(e.style.transformOrigin=c),e.style.transitionProperty=null,e.style.transitionDuration=null,e.style.transitionTimingFunction=null}};z(e,p,s,r)}const D=(e,t,n)=>"function"==typeof e?n.evaluateReturnExpression(t,e):e;function N(e,t,n,i,r){R(e,k(D((n.find((e=>"enter"===e.value))||{expression:""}).expression,e,t)),k(D((n.find((e=>"enter-start"===e.value))||{expression:""}).expression,e,t)),k(D((n.find((e=>"enter-end"===e.value))||{expression:""}).expression,e,t)),i,(()=>{}),E,r)}function L(e,t,n,i,r){R(e,k(D((n.find((e=>"leave"===e.value))||{expression:""}).expression,e,t)),k(D((n.find((e=>"leave-start"===e.value))||{expression:""}).expression,e,t)),k(D((n.find((e=>"leave-end"===e.value))||{expression:""}).expression,e,t)),(()=>{}),i,O,r)}function R(e,t,n,i,r,o,s,a){e.__x_transition&&e.__x_transition.cancel&&e.__x_transition.cancel();const l=e.__x_original_classes||[],c={start(){e.classList.add(...n)},during(){e.classList.add(...t)},show(){r()},end(){e.classList.remove(...n.filter((e=>!l.includes(e)))),e.classList.add(...i)},hide(){o()},cleanup(){e.classList.remove(...t.filter((e=>!l.includes(e)))),e.classList.remove(...i.filter((e=>!l.includes(e))))}};z(e,c,s,a)}function z(e,t,n,i){const r=F((()=>{t.hide(),e.isConnected&&t.cleanup(),delete e.__x_transition}));e.__x_transition={type:n,cancel:F((()=>{i(S),r()})),finish:r,nextFrame:null},t.start(),t.during(),e.__x_transition.nextFrame=requestAnimationFrame((()=>{let n=1e3*Number(getComputedStyle(e).transitionDuration.replace(/,.*/,"").replace("s",""));0===n&&(n=1e3*Number(getComputedStyle(e).animationDuration.replace("s",""))),t.show(),e.__x_transition.nextFrame=requestAnimationFrame((()=>{t.end(),setTimeout(e.__x_transition.finish,n)}))}))}function M(e){return!Array.isArray(e)&&!isNaN(e)}function F(e){let t=!1;return function(){t||(t=!0,e.apply(this,arguments))}}function I(e,t,n,i,r){a(t,"x-for");let o=q("function"==typeof n?e.evaluateReturnExpression(t,n):n),s=U(e,t,o,r),l=t;s.forEach(((n,a)=>{let c=B(o,n,a,s,r()),u=K(e,t,a,c),f=V(l.nextElementSibling,u);f?(delete f.__x_for_key,f.__x_for=c,e.updateElements(f,(()=>f.__x_for))):(f=W(t,l),P(f,(()=>{}),(()=>{}),e,i),f.__x_for=c,e.initializeElements(f,(()=>f.__x_for))),l=f,l.__x_for_key=u})),G(l,e)}function q(e){let t=/,([^,\}\]]*)(?:,([^,\}\]]*))?$/,n=/^\(|\)$/g,i=/([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,r=String(e).match(i);if(!r)return;let o={};o.items=r[2].trim();let s=r[1].trim().replace(n,""),a=s.match(t);return a?(o.item=s.replace(t,"").trim(),o.index=a[1].trim(),a[2]&&(o.collection=a[2].trim())):o.item=s,o}function B(e,t,i,r,o){let s=o?n({},o):{};return s[e.item]=t,e.index&&(s[e.index]=i),e.collection&&(s[e.collection]=r),s}function K(e,t,n,i){let r=b(t,e,"bind").filter((e=>"key"===e.value))[0];return r?e.evaluateReturnExpression(t,r.expression,(()=>i)):n}function U(e,t,n,i){let r=b(t,e,"if")[0];if(r&&!e.evaluateReturnExpression(t,r.expression))return[];let o=e.evaluateReturnExpression(t,n.items,i);return M(o)&&o>=0&&(o=Array.from(Array(o).keys(),(e=>e+1))),o}function W(e,t){let n=document.importNode(e.content,!0);return t.parentElement.insertBefore(n,t.nextElementSibling),t.nextElementSibling}function V(e,t){if(!e)return;if(void 0===e.__x_for_key)return;if(e.__x_for_key===t)return e;let n=e;for(;n;){if(n.__x_for_key===t)return n.parentElement.insertBefore(n,e);n=!(!n.nextElementSibling||void 0===n.nextElementSibling.__x_for_key)&&n.nextElementSibling}}function G(e,t){for(var n=!(!e.nextElementSibling||void 0===e.nextElementSibling.__x_for_key)&&e.nextElementSibling;n;){let e=n,i=n.nextElementSibling;A(n,(()=>{e.remove()}),(()=>{}),t),n=!(!i||void 0===i.__x_for_key)&&i}}function H(e,t,n,i,o,a,l){var u=e.evaluateReturnExpression(t,i,o);if("value"===n){if(Ve.ignoreFocusedForValueBinding&&document.activeElement.isSameNode(t))return;if(void 0===u&&String(i).match(/\./)&&(u=""),"radio"===t.type)void 0===t.attributes.value&&"bind"===a?t.value=u:"bind"!==a&&(t.checked=s(t.value,u));else if("checkbox"===t.type)"boolean"==typeof u||[null,void 0].includes(u)||"bind"!==a?"bind"!==a&&(Array.isArray(u)?t.checked=u.some((e=>s(e,t.value))):t.checked=!!u):t.value=String(u);else if("SELECT"===t.tagName)X(t,u);else{if(t.value===u)return;t.value=u}}else if("class"===n)if(Array.isArray(u)){const e=t.__x_original_classes||[];t.setAttribute("class",r(e.concat(u)).join(" "))}else if("object"==typeof u)Object.keys(u).sort(((e,t)=>u[e]-u[t])).forEach((e=>{u[e]?k(e).forEach((e=>t.classList.add(e))):k(e).forEach((e=>t.classList.remove(e)))}));else{const e=t.__x_original_classes||[],n=u?k(u):[];t.setAttribute("class",r(e.concat(n)).join(" "))}else n=l.includes("camel")?c(n):n,[null,void 0,!1].includes(u)?t.removeAttribute(n):_(n)?Z(t,n,n):Z(t,n,u)}function Z(e,t,n){e.getAttribute(t)!=n&&e.setAttribute(t,n)}function X(e,t){const n=[].concat(t).map((e=>e+""));Array.from(e.options).forEach((e=>{e.selected=n.includes(e.value||e.text)}))}function J(e,t,n){void 0===t&&String(n).match(/\./)&&(t=""),e.textContent=t}function Q(e,t,n,i){t.innerHTML=e.evaluateReturnExpression(t,n,i)}function Y(e,t,n,i,r=!1){const o=()=>{t.style.display="none",t.__x_is_shown=!1},s=()=>{1===t.style.length&&"none"===t.style.display?t.removeAttribute("style"):t.style.removeProperty("display"),t.__x_is_shown=!0};if(!0===r)return void(n?s():o());const a=(i,r)=>{n?(("none"===t.style.display||t.__x_transition)&&P(t,(()=>{s()}),r,e),i((()=>{}))):"none"!==t.style.display?A(t,(()=>{i((()=>{o()}))}),r,e):i((()=>{}))};i.includes("immediate")?a((e=>e()),(()=>{})):(e.showDirectiveLastElement&&!e.showDirectiveLastElement.contains(t)&&e.executeAndClearRemainingShowDirectiveStack(),e.showDirectiveStack.push(a),e.showDirectiveLastElement=t)}function ee(e,t,n,i,r){a(t,"x-if");const o=t.nextElementSibling&&!0===t.nextElementSibling.__x_inserted_me;if(!n||o&&!t.__x_transition)!n&&o&&A(t.nextElementSibling,(()=>{t.nextElementSibling.remove()}),(()=>{}),e,i);else{const n=document.importNode(t.content,!0);t.parentElement.insertBefore(n,t.nextElementSibling),P(t.nextElementSibling,(()=>{}),(()=>{}),e,i),e.initializeElements(t.nextElementSibling,r),t.nextElementSibling.__x_inserted_me=!0}}function te(e,t,n,i,r,o={}){const s={passive:i.includes("passive")};let a,l;if(i.includes("camel")&&(n=c(n)),i.includes("away")?(l=document,a=l=>{t.contains(l.target)||t.offsetWidth<1&&t.offsetHeight<1||(ne(e,r,l,o),i.includes("once")&&document.removeEventListener(n,a,s))}):(l=i.includes("window")?window:i.includes("document")?document:t,a=c=>{l!==window&&l!==document||document.body.contains(t)?ie(n)&&re(c,i)||(i.includes("prevent")&&c.preventDefault(),i.includes("stop")&&c.stopPropagation(),i.includes("self")&&c.target!==t)||ne(e,r,c,o).then((e=>{!1===e?c.preventDefault():i.includes("once")&&l.removeEventListener(n,a,s)})):l.removeEventListener(n,a,s)}),i.includes("debounce")){let e=i[i.indexOf("debounce")+1]||"invalid-wait",t=M(e.split("ms")[0])?Number(e.split("ms")[0]):250;a=f(a,t)}l.addEventListener(n,a,s)}function ne(e,t,i,r){return e.evaluateCommandExpression(i.target,t,(()=>n(n({},r()),{},{$event:i})))}function ie(e){return["keydown","keyup"].includes(e)}function re(e,t){let n=t.filter((e=>!["window","document","prevent","stop"].includes(e)));if(n.includes("debounce")){let e=n.indexOf("debounce");n.splice(e,M((n[e+1]||"invalid-wait").split("ms")[0])?2:1)}if(0===n.length)return!1;if(1===n.length&&n[0]===oe(e.key))return!1;const i=["ctrl","shift","alt","meta","cmd","super"].filter((e=>n.includes(e)));return n=n.filter((e=>!i.includes(e))),!(i.length>0&&i.filter((t=>("cmd"!==t&&"super"!==t||(t="meta"),e[`${t}Key`]))).length===i.length&&n[0]===oe(e.key))}function oe(e){switch(e){case"/":return"slash";case" ":case"Spacebar":return"space";default:return e&&l(e)}}function se(e,t,i,r,o){var s="select"===t.tagName.toLowerCase()||["checkbox","radio"].includes(t.type)||i.includes("lazy")?"change":"input";te(e,t,s,i,`${r} = rightSideOfExpression($event, ${r})`,(()=>n(n({},o()),{},{rightSideOfExpression:ae(t,i,r)})))}function ae(e,t,n){return"radio"===e.type&&(e.hasAttribute("name")||e.setAttribute("name",n)),(n,i)=>{if(n instanceof CustomEvent&&n.detail)return n.detail;if("checkbox"===e.type){if(Array.isArray(i)){const e=t.includes("number")?le(n.target.value):n.target.value;return n.target.checked?i.concat([e]):i.filter((t=>!s(t,e)))}return n.target.checked}if("select"===e.tagName.toLowerCase()&&e.multiple)return t.includes("number")?Array.from(n.target.selectedOptions).map((e=>le(e.value||e.text))):Array.from(n.target.selectedOptions).map((e=>e.value||e.text));{const e=n.target.value;return t.includes("number")?le(e):t.includes("trim")?e.trim():e}}}function le(e){const t=e?parseFloat(e):null;return M(t)?t:e}const{isArray:ce}=Array,{getPrototypeOf:ue,create:fe,defineProperty:de,defineProperties:pe,isExtensible:he,getOwnPropertyDescriptor:me,getOwnPropertyNames:ye,getOwnPropertySymbols:ve,preventExtensions:be,hasOwnProperty:ge}=Object,{push:xe,concat:_e,map:we}=Array.prototype;function ke(e){return void 0===e}function Ee(e){return"function"==typeof e}function Oe(e){return"object"==typeof e}const Se=new WeakMap;function Pe(e,t){Se.set(e,t)}const Ae=e=>Se.get(e)||e;function $e(e,t){return e.valueIsObservable(t)?e.getProxy(t):t}function Ce(e){return ge.call(e,"value")&&(e.value=Ae(e.value)),e}function je(e,t,n){_e.call(ye(n),ve(n)).forEach((i=>{let r=me(n,i);r.configurable||(r=qe(e,r,$e)),de(t,i,r)})),be(t)}class Te{constructor(e,t){this.originalTarget=t,this.membrane=e}get(e,t){const{originalTarget:n,membrane:i}=this,r=n[t],{valueObserved:o}=i;return o(n,t),i.getProxy(r)}set(e,t,n){const{originalTarget:i,membrane:{valueMutated:r}}=this;return i[t]!==n?(i[t]=n,r(i,t)):"length"===t&&ce(i)&&r(i,t),!0}deleteProperty(e,t){const{originalTarget:n,membrane:{valueMutated:i}}=this;return delete n[t],i(n,t),!0}apply(e,t,n){}construct(e,t,n){}has(e,t){const{originalTarget:n,membrane:{valueObserved:i}}=this;return i(n,t),t in n}ownKeys(e){const{originalTarget:t}=this;return _e.call(ye(t),ve(t))}isExtensible(e){const t=he(e);if(!t)return t;const{originalTarget:n,membrane:i}=this,r=he(n);return r||je(i,e,n),r}setPrototypeOf(e,t){}getPrototypeOf(e){const{originalTarget:t}=this;return ue(t)}getOwnPropertyDescriptor(e,t){const{originalTarget:n,membrane:i}=this,{valueObserved:r}=this.membrane;r(n,t);let o=me(n,t);if(ke(o))return o;const s=me(e,t);return ke(s)?(o=qe(i,o,$e),o.configurable||de(e,t,o),o):s}preventExtensions(e){const{originalTarget:t,membrane:n}=this;return je(n,e,t),be(t),!0}defineProperty(e,t,n){const{originalTarget:i,membrane:r}=this,{valueMutated:o}=r,{configurable:s}=n;if(ge.call(n,"writable")&&!ge.call(n,"value")){const e=me(i,t);n.value=e.value}return de(i,t,Ce(n)),!1===s&&de(e,t,qe(r,n,$e)),o(i,t),!0}}function De(e,t){return e.valueIsObservable(t)?e.getReadOnlyProxy(t):t}class Ne{constructor(e,t){this.originalTarget=t,this.membrane=e}get(e,t){const{membrane:n,originalTarget:i}=this,r=i[t],{valueObserved:o}=n;return o(i,t),n.getReadOnlyProxy(r)}set(e,t,n){return!1}deleteProperty(e,t){return!1}apply(e,t,n){}construct(e,t,n){}has(e,t){const{originalTarget:n,membrane:{valueObserved:i}}=this;return i(n,t),t in n}ownKeys(e){const{originalTarget:t}=this;return _e.call(ye(t),ve(t))}setPrototypeOf(e,t){}getOwnPropertyDescriptor(e,t){const{originalTarget:n,membrane:i}=this,{valueObserved:r}=i;r(n,t);let o=me(n,t);if(ke(o))return o;const s=me(e,t);return ke(s)?(o=qe(i,o,De),ge.call(o,"set")&&(o.set=void 0),o.configurable||de(e,t,o),o):s}preventExtensions(e){return!1}defineProperty(e,t,n){return!1}}function Le(e){let t;return ce(e)?t=[]:Oe(e)&&(t={}),t}const Re=Object.prototype;function ze(e){if(null===e)return!1;if("object"!=typeof e)return!1;if(ce(e))return!0;const t=ue(e);return t===Re||null===t||null===ue(t)}const Me=(e,t)=>{},Fe=(e,t)=>{},Ie=e=>e;function qe(e,t,n){const{set:i,get:r}=t;return ge.call(t,"value")?t.value=n(e,t.value):(ke(r)||(t.get=function(){return n(e,r.call(Ae(this)))}),ke(i)||(t.set=function(t){i.call(Ae(this),e.unwrapProxy(t))})),t}class Be{constructor(e){if(this.valueDistortion=Ie,this.valueMutated=Fe,this.valueObserved=Me,this.valueIsObservable=ze,this.objectGraph=new WeakMap,!ke(e)){const{valueDistortion:t,valueMutated:n,valueObserved:i,valueIsObservable:r}=e;this.valueDistortion=Ee(t)?t:Ie,this.valueMutated=Ee(n)?n:Fe,this.valueObserved=Ee(i)?i:Me,this.valueIsObservable=Ee(r)?r:ze}}getProxy(e){const t=Ae(e),n=this.valueDistortion(t);if(this.valueIsObservable(n)){const i=this.getReactiveState(t,n);return i.readOnly===e?e:i.reactive}return n}getReadOnlyProxy(e){e=Ae(e);const t=this.valueDistortion(e);return this.valueIsObservable(t)?this.getReactiveState(e,t).readOnly:t}unwrapProxy(e){return Ae(e)}getReactiveState(e,t){const{objectGraph:n}=this;let i=n.get(t);if(i)return i;const r=this;return i={get reactive(){const n=new Te(r,t),i=new Proxy(Le(t),n);return Pe(i,e),de(this,"reactive",{value:i}),i},get readOnly(){const n=new Ne(r,t),i=new Proxy(Le(t),n);return Pe(i,e),de(this,"readOnly",{value:i}),i}},n.set(t,i),i}}function Ke(e,t){let n=new Be({valueMutated(e,n){t(e,n)}});return{data:n.getProxy(e),membrane:n}}function Ue(e,t){let n=e.unwrapProxy(t),i={};return Object.keys(n).forEach((e=>{["$el","$refs","$nextTick","$watch"].includes(e)||(i[e]=n[e])})),i}class We{constructor(e,t=null){this.$el=e;const n=this.$el.getAttribute("x-data"),i=""===n?"{}":n,r=this.$el.getAttribute("x-init");let o={$el:this.$el},s=t?t.$el:this.$el;Object.entries(Ve.magicProperties).forEach((([e,t])=>{Object.defineProperty(o,`$${e}`,{get:function(){return t(s)}})})),this.unobservedData=t?t.getUnobservedData():h(e,i,o);let{membrane:a,data:l}=this.wrapDataInObservable(this.unobservedData);var c;this.$data=l,this.membrane=a,this.unobservedData.$el=this.$el,this.unobservedData.$refs=this.getRefsProxy(),this.nextTickStack=[],this.unobservedData.$nextTick=e=>{this.nextTickStack.push(e)},this.watchers={},this.unobservedData.$watch=(e,t)=>{this.watchers[e]||(this.watchers[e]=[]),this.watchers[e].push(t)},Object.entries(Ve.magicProperties).forEach((([e,t])=>{Object.defineProperty(this.unobservedData,`$${e}`,{get:function(){return t(s,this.$el)}})})),this.showDirectiveStack=[],this.showDirectiveLastElement,t||Ve.onBeforeComponentInitializeds.forEach((e=>e(this))),r&&!t&&(this.pauseReactivity=!0,c=this.evaluateReturnExpression(this.$el,r),this.pauseReactivity=!1),this.initializeElements(this.$el,(()=>{}),!t),this.listenForNewElementsToInitialize(),"function"==typeof c&&c.call(this.$data),t||setTimeout((()=>{Ve.onComponentInitializeds.forEach((e=>e(this)))}),0)}getUnobservedData(){return Ue(this.membrane,this.$data)}wrapDataInObservable(e){var t=this;let n=f((function(){t.updateElements(t.$el)}),0);return Ke(e,((e,i)=>{t.watchers[i]?t.watchers[i].forEach((t=>t(e[i]))):Array.isArray(e)?Object.keys(t.watchers).forEach((n=>{let r=n.split(".");"length"!==i&&r.reduce(((i,r)=>(Object.is(e,i[r])&&t.watchers[n].forEach((t=>t(e))),i[r])),t.unobservedData)})):Object.keys(t.watchers).filter((e=>e.includes("."))).forEach((n=>{let r=n.split(".");i===r[r.length-1]&&r.reduce(((r,o)=>(Object.is(e,r)&&t.watchers[n].forEach((t=>t(e[i]))),r[o])),t.unobservedData)})),t.pauseReactivity||n()}))}walkAndSkipNestedComponents(e,t,n=(()=>{})){u(e,(e=>e.hasAttribute("x-data")&&!e.isSameNode(this.$el)?(e.__x||n(e),!1):t(e)))}initializeElements(e,t=(()=>{}),n=!0){this.walkAndSkipNestedComponents(e,(e=>void 0===e.__x_for_key&&void 0===e.__x_inserted_me&&void this.initializeElement(e,t,n)),(e=>{e.__x=new We(e)})),this.executeAndClearRemainingShowDirectiveStack(),this.executeAndClearNextTickStack(e)}initializeElement(e,t,n=!0){e.hasAttribute("class")&&b(e,this).length>0&&(e.__x_original_classes=k(e.getAttribute("class"))),n&&this.registerListeners(e,t),this.resolveBoundAttributes(e,!0,t)}updateElements(e,t=(()=>{})){this.walkAndSkipNestedComponents(e,(e=>{if(void 0!==e.__x_for_key&&!e.isSameNode(this.$el))return!1;this.updateElement(e,t)}),(e=>{e.__x=new We(e)})),this.executeAndClearRemainingShowDirectiveStack(),this.executeAndClearNextTickStack(e)}executeAndClearNextTickStack(e){e===this.$el&&this.nextTickStack.length>0&&requestAnimationFrame((()=>{for(;this.nextTickStack.length>0;)this.nextTickStack.shift()()}))}executeAndClearRemainingShowDirectiveStack(){this.showDirectiveStack.reverse().map((e=>new Promise(((t,n)=>{e(t,n)})))).reduce(((e,t)=>e.then((()=>t.then((e=>{e()}))))),Promise.resolve((()=>{}))).catch((e=>{if(e!==S)throw e})),this.showDirectiveStack=[],this.showDirectiveLastElement=void 0}updateElement(e,t){this.resolveBoundAttributes(e,!1,t)}registerListeners(e,t){b(e,this).forEach((({type:n,value:i,modifiers:r,expression:o})=>{switch(n){case"on":te(this,e,i,r,o,t);break;case"model":se(this,e,r,o,t)}}))}resolveBoundAttributes(e,t=!1,n){let i=b(e,this);i.forEach((({type:r,value:o,modifiers:s,expression:a})=>{switch(r){case"model":H(this,e,"value",a,n,r,s);break;case"bind":if("template"===e.tagName.toLowerCase()&&"key"===o)return;H(this,e,o,a,n,r,s);break;case"text":var l=this.evaluateReturnExpression(e,a,n);J(e,l,a);break;case"html":Q(this,e,a,n);break;case"show":l=this.evaluateReturnExpression(e,a,n),Y(this,e,l,s,t);break;case"if":if(i.some((e=>"for"===e.type)))return;l=this.evaluateReturnExpression(e,a,n),ee(this,e,l,t,n);break;case"for":I(this,e,a,t,n);break;case"cloak":e.removeAttribute("x-cloak")}}))}evaluateReturnExpression(e,t,i=(()=>{})){return h(e,t,this.$data,n(n({},i()),{},{$dispatch:this.getDispatchFunction(e)}))}evaluateCommandExpression(e,t,i=(()=>{})){return m(e,t,this.$data,n(n({},i()),{},{$dispatch:this.getDispatchFunction(e)}))}getDispatchFunction(e){return(t,n={})=>{e.dispatchEvent(new CustomEvent(t,{detail:n,bubbles:!0}))}}listenForNewElementsToInitialize(){const e=this.$el,t={childList:!0,attributes:!0,subtree:!0};new MutationObserver((e=>{for(let t=0;t<e.length;t++){const n=e[t].target.closest("[x-data]");if(n&&n.isSameNode(this.$el)){if("attributes"===e[t].type&&"x-data"===e[t].attributeName){const n=e[t].target.getAttribute("x-data")||"{}",i=h(this.$el,n,{$el:this.$el});Object.keys(i).forEach((e=>{this.$data[e]!==i[e]&&(this.$data[e]=i[e])}))}e[t].addedNodes.length>0&&e[t].addedNodes.forEach((e=>{1!==e.nodeType||e.__x_inserted_me||(!e.matches("[x-data]")||e.__x?this.initializeElements(e):e.__x=new We(e))}))}}})).observe(e,t)}getRefsProxy(){var e=this;return new Proxy({},{get(t,n){return"$isAlpineProxy"===n||(e.walkAndSkipNestedComponents(e.$el,(e=>{e.hasAttribute("x-ref")&&e.getAttribute("x-ref")===n&&(i=e)})),i);var i}})}}const Ve={version:"2.8.1",pauseMutationObserver:!1,magicProperties:{},onComponentInitializeds:[],onBeforeComponentInitializeds:[],ignoreFocusedForValueBinding:!1,start:async function(){o()||await i(),this.discoverComponents((e=>{this.initializeComponent(e)})),document.addEventListener("turbolinks:load",(()=>{this.discoverUninitializedComponents((e=>{this.initializeComponent(e)}))})),this.listenForNewUninitializedComponentsAtRunTime()},discoverComponents:function(e){document.querySelectorAll("[x-data]").forEach((t=>{e(t)}))},discoverUninitializedComponents:function(e,t=null){const n=(t||document).querySelectorAll("[x-data]");Array.from(n).filter((e=>void 0===e.__x)).forEach((t=>{e(t)}))},listenForNewUninitializedComponentsAtRunTime:function(){const e=document.querySelector("body"),t={childList:!0,attributes:!0,subtree:!0};new MutationObserver((e=>{if(!this.pauseMutationObserver)for(let t=0;t<e.length;t++)e[t].addedNodes.length>0&&e[t].addedNodes.forEach((e=>{1===e.nodeType&&(e.parentElement&&e.parentElement.closest("[x-data]")||this.discoverUninitializedComponents((e=>{this.initializeComponent(e)}),e.parentElement))}))})).observe(e,t)},initializeComponent:function(e){if(!e.__x)try{e.__x=new We(e)}catch(e){setTimeout((()=>{throw e}),0)}},clone:function(e,t){t.__x||(t.__x=new We(t,e))},addMagicProperty:function(e,t){this.magicProperties[e]=t},onComponentInitialized:function(e){this.onComponentInitializeds.push(e)},onBeforeComponentInitialized:function(e){this.onBeforeComponentInitializeds.push(e)}};return o()||(window.Alpine=Ve,window.deferLoadingAlpine?window.deferLoadingAlpine((function(){window.Alpine.start()})):window.Alpine.start()),Ve}()},908:(e,t,n)=>{"use strict";n.r(t),n.d(t,{UiServiceProvider:()=>d});n(443);var i=n(441),r=n.n(i);function o(e){return(o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function s(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function a(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}function l(e,t){return(l=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function c(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,i=f(e);if(t){var r=f(this).constructor;n=Reflect.construct(i,arguments,r)}else n=i.apply(this,arguments);return u(this,n)}}function u(e,t){return!t||"object"!==o(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function f(e){return(f=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var d=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&l(e,t)}(u,e);var t,n,i,o=c(u);function u(){return s(this,u),o.apply(this,arguments)}return t=u,(n=[{key:"boot",value:function(){document.querySelectorAll("[data-keymap]").forEach((function(e){r().bind(e.dataset.keymap,(function(t){t.preventDefault(),"INPUT"==e.tagName?e.focus():e.click()}))}))}}])&&a(t.prototype,n),i&&a(t,i),u}(window.streams.core.ServiceProvider)},310:()=>{},865:()=>{},930:()=>{},441:(e,t,n)=>{var i;!function(r,o,s){if(r){for(var a,l={8:"backspace",9:"tab",13:"enter",16:"shift",17:"ctrl",18:"alt",20:"capslock",27:"esc",32:"space",33:"pageup",34:"pagedown",35:"end",36:"home",37:"left",38:"up",39:"right",40:"down",45:"ins",46:"del",91:"meta",93:"meta",224:"meta"},c={106:"*",107:"+",109:"-",110:".",111:"/",186:";",187:"=",188:",",189:"-",190:".",191:"/",192:"`",219:"[",220:"\\",221:"]",222:"'"},u={"~":"`","!":"1","@":"2","#":"3",$:"4","%":"5","^":"6","&":"7","*":"8","(":"9",")":"0",_:"-","+":"=",":":";",'"':"'","<":",",">":".","?":"/","|":"\\"},f={option:"alt",command:"meta",return:"enter",escape:"esc",plus:"+",mod:/Mac|iPod|iPhone|iPad/.test(navigator.platform)?"meta":"ctrl"},d=1;d<20;++d)l[111+d]="f"+d;for(d=0;d<=9;++d)l[d+96]=d.toString();g.prototype.bind=function(e,t,n){var i=this;return e=e instanceof Array?e:[e],i._bindMultiple.call(i,e,t,n),i},g.prototype.unbind=function(e,t){return this.bind.call(this,e,(function(){}),t)},g.prototype.trigger=function(e,t){var n=this;return n._directMap[e+":"+t]&&n._directMap[e+":"+t]({},e),n},g.prototype.reset=function(){var e=this;return e._callbacks={},e._directMap={},e},g.prototype.stopCallback=function(e,t){if((" "+t.className+" ").indexOf(" mousetrap ")>-1)return!1;if(b(t,this.target))return!1;if("composedPath"in e&&"function"==typeof e.composedPath){var n=e.composedPath()[0];n!==e.target&&(t=n)}return"INPUT"==t.tagName||"SELECT"==t.tagName||"TEXTAREA"==t.tagName||t.isContentEditable},g.prototype.handleKey=function(){var e=this;return e._handleKey.apply(e,arguments)},g.addKeycodes=function(e){for(var t in e)e.hasOwnProperty(t)&&(l[t]=e[t]);a=null},g.init=function(){var e=g(o);for(var t in e)"_"!==t.charAt(0)&&(g[t]=function(t){return function(){return e[t].apply(e,arguments)}}(t))},g.init(),r.Mousetrap=g,e.exports&&(e.exports=g),void 0===(i=function(){return g}.call(t,n,t,e))||(e.exports=i)}function p(e,t,n){e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent("on"+t,n)}function h(e){if("keypress"==e.type){var t=String.fromCharCode(e.which);return e.shiftKey||(t=t.toLowerCase()),t}return l[e.which]?l[e.which]:c[e.which]?c[e.which]:String.fromCharCode(e.which).toLowerCase()}function m(e){return"shift"==e||"ctrl"==e||"alt"==e||"meta"==e}function y(e,t,n){return n||(n=function(){if(!a)for(var e in a={},l)e>95&&e<112||l.hasOwnProperty(e)&&(a[l[e]]=e);return a}()[e]?"keydown":"keypress"),"keypress"==n&&t.length&&(n="keydown"),n}function v(e,t){var n,i,r,o=[];for(n=function(e){return"+"===e?["+"]:(e=e.replace(/\+{2}/g,"+plus")).split("+")}(e),r=0;r<n.length;++r)i=n[r],f[i]&&(i=f[i]),t&&"keypress"!=t&&u[i]&&(i=u[i],o.push("shift")),m(i)&&o.push(i);return{key:i,modifiers:o,action:t=y(i,o,t)}}function b(e,t){return null!==e&&e!==o&&(e===t||b(e.parentNode,t))}function g(e){var t=this;if(e=e||o,!(t instanceof g))return new g(e);t.target=e,t._callbacks={},t._directMap={};var n,i={},r=!1,s=!1,a=!1;function l(e){e=e||{};var t,n=!1;for(t in i)e[t]?n=!0:i[t]=0;n||(a=!1)}function c(e,n,r,o,s,a){var l,c,u,f,d=[],p=r.type;if(!t._callbacks[e])return[];for("keyup"==p&&m(e)&&(n=[e]),l=0;l<t._callbacks[e].length;++l)if(c=t._callbacks[e][l],(o||!c.seq||i[c.seq]==c.level)&&p==c.action&&("keypress"==p&&!r.metaKey&&!r.ctrlKey||(u=n,f=c.modifiers,u.sort().join(",")===f.sort().join(",")))){var h=!o&&c.combo==s,y=o&&c.seq==o&&c.level==a;(h||y)&&t._callbacks[e].splice(l,1),d.push(c)}return d}function u(e,n,i,r){t.stopCallback(n,n.target||n.srcElement,i,r)||!1===e(n,i)&&(function(e){e.preventDefault?e.preventDefault():e.returnValue=!1}(n),function(e){e.stopPropagation?e.stopPropagation():e.cancelBubble=!0}(n))}function f(e){"number"!=typeof e.which&&(e.which=e.keyCode);var n=h(e);n&&("keyup"!=e.type||r!==n?t.handleKey(n,function(e){var t=[];return e.shiftKey&&t.push("shift"),e.altKey&&t.push("alt"),e.ctrlKey&&t.push("ctrl"),e.metaKey&&t.push("meta"),t}(e),e):r=!1)}function d(e,t,o,s){function c(t){return function(){a=t,++i[e],clearTimeout(n),n=setTimeout(l,1e3)}}function f(t){u(o,t,e),"keyup"!==s&&(r=h(t)),setTimeout(l,10)}i[e]=0;for(var d=0;d<t.length;++d){var p=d+1===t.length?f:c(s||v(t[d+1]).action);y(t[d],p,s,e,d)}}function y(e,n,i,r,o){t._directMap[e+":"+i]=n;var s,a=(e=e.replace(/\s+/g," ")).split(" ");a.length>1?d(e,a,n,i):(s=v(e,i),t._callbacks[s.key]=t._callbacks[s.key]||[],c(s.key,s.modifiers,{type:s.action},r,e,o),t._callbacks[s.key][r?"unshift":"push"]({callback:n,modifiers:s.modifiers,action:s.action,seq:r,level:o,combo:e}))}t._handleKey=function(e,t,n){var i,r=c(e,t,n),o={},f=0,d=!1;for(i=0;i<r.length;++i)r[i].seq&&(f=Math.max(f,r[i].level));for(i=0;i<r.length;++i)if(r[i].seq){if(r[i].level!=f)continue;d=!0,o[r[i].seq]=1,u(r[i].callback,n,r[i].combo,r[i].seq)}else d||u(r[i].callback,n,r[i].combo);var p="keypress"==n.type&&s;n.type!=a||m(e)||p||l(o),s=d&&"keydown"==n.type},t._bindMultiple=function(e,t,n){for(var i=0;i<e.length;++i)y(e[i],t,n)},p(e,"keypress",f),p(e,"keydown",f),p(e,"keyup",f)}}("undefined"!=typeof window?window:null,"undefined"!=typeof window?document:null)}},t={};function n(i){if(t[i])return t[i].exports;var r=t[i]={exports:{}};return e[i].call(r.exports,r,r.exports,n),r.exports}n.m=e,n.x=e=>{},n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var i in t)n.o(t,i)&&!n.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:t[i]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),n.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},(()=>{var e={769:0},t=[[930],[865],[310],[908]],i=e=>{},r=(r,o)=>{for(var s,a,[l,c,u,f]=o,d=0,p=[];d<l.length;d++)a=l[d],n.o(e,a)&&e[a]&&p.push(e[a][0]),e[a]=0;for(s in c)n.o(c,s)&&(n.m[s]=c[s]);for(u&&u(n),r&&r(o);p.length;)p.shift()();return f&&t.push.apply(t,f),i()},o=self.webpackChunkstreams_ui=self.webpackChunkstreams_ui||[];function s(){for(var i,r=0;r<t.length;r++){for(var o=t[r],s=!0,a=1;a<o.length;a++){var l=o[a];0!==e[l]&&(s=!1)}s&&(t.splice(r--,1),i=n(n.s=o[0]))}return 0===t.length&&(n.x(),n.x=e=>{}),i}o.forEach(r.bind(null,0)),o.push=r.bind(null,o.push.bind(o));var a=n.x;n.x=()=>(n.x=a||(e=>{}),(i=s)())})();var i=n.x();(window.streams=window.streams||{}).ui=i})();
//# sourceMappingURL=index.js.map