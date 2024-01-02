import React from "react";
import {createRoot} from "react-dom/client"

function Articles () {
    return <h2>Coucou React !</h2>;
}

class ArticlesElement extends HTMLElement {

    connectedCallback(){
        const root = createRoot(this)
        root.render(<Articles />)
    }  
}

customElements.define( 'articles-component', ArticlesElement)