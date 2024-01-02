import {default as React} from 'react'
import {render} from 'react-dom'

function Hello () {
    return <div>Bonjour toi !</div>
}

render(<Hello />, document.querySelector('#comments'))

