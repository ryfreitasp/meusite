<div id="carrinho-overlay" onclick="toggleCarrinho()" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:999;"></div>

<aside id="carrinho-lateral" class="carrinho-sidebar" style="position:fixed; right:-400px; top:0; width:350px; height:100%; background:#111; z-index:1000; transition:0.3s; display:flex; flex-direction:column;">
    <div class="carrinho-header" style="padding:20px; border-bottom:1px solid #333; display:flex; justify-content:space-between; align-items:center;">
        <h2 style="color:#fff; margin:0;">Meu Carrinho</h2>
        <button onclick="toggleCarrinho()" style="background:none; border:none; color:#8a2be2; font-size:30px; cursor:pointer;">&times;</button>
    </div>
    
    <div id="itens-do-carrinho" style="flex-grow:1; overflow-y:auto; padding:20px;">
        </div>

    <div class="carrinho-footer" style="padding:20px; border-top:1px solid #333;">
        <div style="display:flex; justify-content:space-between; color:#fff; margin-bottom:15px;">
            <span>Total:</span>
            <span id="valor-total-carrinho">R$ 0,00</span>
        </div>
        <button onclick="window.location.href='checkout.php'" style="width:100%; background:#8a2be2; color:#fff; border:none; padding:15px; border-radius:5px; font-weight:bold; cursor:pointer;">FINALIZAR COMPRA</button>
    </div>
</aside>