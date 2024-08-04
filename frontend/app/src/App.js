import React, { useState, useEffect } from 'react';
import axios from 'axios';

function App() {
    const [items, setItems] = useState([]);
    const [newItem, setNewItem] = useState('');

    useEffect(() => {
        axios.get('http://localhost:9000/api/items')
            .then(response => setItems(response.data))
            .catch(error => console.error(error));
    }, []);

    const addItem = () => {
        axios.post('http://localhost:9000/api/items', { name: newItem })
            .then(response => setItems([...items, response.data]))
            .catch(error => console.error(error));
    };

    return (
        <div>
            <h1>Items</h1>
            <input
                type="text"
                value={newItem}
                onChange={(e) => setNewItem(e.target.value)}
            />
            <button onClick={addItem}>Add Item</button>
            <ul>
                {items.map(item => (
                    <li key={item.id}>{item.name}</li>
                ))}
            </ul>
        </div>
    );
}

export default App;