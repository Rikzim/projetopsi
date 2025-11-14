// Objeto para armazenar dados dos bilhetes
const bilhetesData = {};

// Inicializar ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    console.log('Bilhetes JS carregado!');
    
    // Coletar todos os botões plus e suas informações
    document.querySelectorAll('.btn-plus').forEach(btn => {
        const ticketId = btn.getAttribute('data-ticket-id');
        const preco = parseFloat(btn.getAttribute('data-preco')) || 0;
        const max = parseInt(btn.getAttribute('data-max')) || 10;
        const gratuito = btn.getAttribute('data-gratuito') === 'true';
        
        bilhetesData[ticketId] = {
            quantidade: 0,
            preco: preco,
            max: max,
            gratuito: gratuito
        };
        
        console.log('Bilhete registrado:', ticketId, bilhetesData[ticketId]);
    });
    
    // Adicionar event listeners nos botões +
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-ticket-id');
            console.log('Clicou em + para bilhete:', ticketId);
            updateQuantity(ticketId, 1);
        });
    });
    
    // Adicionar event listeners nos botões -
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-ticket-id');
            console.log('Clicou em - para bilhete:', ticketId);
            updateQuantity(ticketId, -1);
        });
    });
    
    // Event listener no botão comprar global
    const btnComprarGlobal = document.getElementById('btn-comprar-global');
    if (btnComprarGlobal) {
        btnComprarGlobal.addEventListener('click', function() {
            finalizarCompra();
        });
    }
});

/**
 * Atualiza a quantidade de um bilhete
 */
function updateQuantity(ticketId, change) {
    console.log('updateQuantity chamado:', ticketId, change);
    
    const data = bilhetesData[ticketId];
    if (!data) {
        console.error('Bilhete não encontrado:', ticketId);
        return;
    }
    
    const newQuantity = data.quantidade + change;
    
    // Validar limites
    if (newQuantity < 0 || newQuantity > data.max) {
        console.log('Quantidade fora dos limites:', newQuantity);
        return;
    }
    
    // Atualizar quantidade
    data.quantidade = newQuantity;
    console.log('Nova quantidade:', newQuantity);
    
    // Atualizar UI
    const quantityEl = document.getElementById('quantity-' + ticketId);
    const btnMinus = document.querySelector('.btn-minus[data-ticket-id="' + ticketId + '"]');
    const btnPlus = document.querySelector('.btn-plus[data-ticket-id="' + ticketId + '"]');
    
    if (quantityEl) {
        quantityEl.textContent = newQuantity;
    }
    
    if (btnMinus) {
        btnMinus.disabled = (newQuantity === 0);
    }
    
    if (btnPlus) {
        btnPlus.disabled = (newQuantity >= data.max);
    }
    
    // Atualizar total
    updateTotal();
}

/**
 * Atualiza o valor total e estado do botão comprar
 */
function updateTotal() {
    let total = 0;
    let totalItems = 0;
    
    Object.keys(bilhetesData).forEach(ticketId => {
        const data = bilhetesData[ticketId];
        if (data.quantidade > 0) {
            total += data.quantidade * data.preco;
            totalItems += data.quantidade;
        }
    });
    
    console.log('Total calculado:', total, 'Items:', totalItems);
    
    // Atualizar valor total
    const totalValueEl = document.getElementById('total-value');
    if (totalValueEl) {
        totalValueEl.textContent = total.toFixed(2).replace('.', ',') + '€';
    }
    
    // Atualizar botão comprar
    const btnComprar = document.getElementById('btn-comprar-global');
    if (btnComprar) {
        btnComprar.disabled = (totalItems === 0);
        
        if (totalItems > 0) {
            btnComprar.textContent = 'Comprar ' + totalItems + ' Bilhete' + (totalItems > 1 ? 's' : '');
        } else {
            btnComprar.textContent = 'Comprar Bilhetes';
        }
    }
}

/**
 * Finaliza a compra
 */
function finalizarCompra() {
    const carrinho = [];
    let total = 0;
    
    Object.keys(bilhetesData).forEach(ticketId => {
        const data = bilhetesData[ticketId];
        if (data.quantidade > 0) {
            carrinho.push({
                id: ticketId,
                quantidade: data.quantidade,
                preco: data.preco,
                subtotal: (data.quantidade * data.preco).toFixed(2)
            });
            total += data.quantidade * data.preco;
        }
    });
    
    if (carrinho.length === 0) {
        alert('Por favor, selecione pelo menos um bilhete.');
        return;
    }
    
    console.log('Carrinho:', carrinho);
    console.log('Total:', total);
    
    // TODO: Implementar envio para o servidor
    alert('🎫 Compra realizada!\n\nTotal de bilhetes: ' + carrinho.length + ' tipo(s)\nValor total: ' + total.toFixed(2) + '€');
    
    // Resetar quantidades
    Object.keys(bilhetesData).forEach(ticketId => {
        bilhetesData[ticketId].quantidade = 0;
        const quantityEl = document.getElementById('quantity-' + ticketId);
        if (quantityEl) {
            quantityEl.textContent = '0';
        }
        
        const btnMinus = document.querySelector('.btn-minus[data-ticket-id="' + ticketId + '"]');
        if (btnMinus) {
            btnMinus.disabled = true;
        }
        
        const btnPlus = document.querySelector('.btn-plus[data-ticket-id="' + ticketId + '"]');
        if (btnPlus) {
            btnPlus.disabled = false;
        }
    });
    
    updateTotal();
}