<?php

use backend\models\Order;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var User $user */

$this->title = 'Заказы';
if ($user) {
    $this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['/user/view', 'id' => $user->id]];
}
$this->params['breadcrumbs'][] = $this->title;

// Cosmic Theme CSS
$this->registerCss('
    * {
        box-sizing: border-box;
    }
    
    body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .order-index {
        background: radial-gradient(ellipse at bottom, #1b2735 0%, #090a0f 100%);
        background-attachment: fixed;
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
        overflow-x: hidden;
    }
    
    .order-index::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 25% 25%, #7928ca 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, #ff0080 0%, transparent 50%),
            radial-gradient(circle at 90% 10%, #4c1d95 0%, transparent 50%),
            radial-gradient(circle at 10% 90%, #1e40af 0%, transparent 50%);
        opacity: 0.1;
        z-index: 0;
        pointer-events: none;
    }
    
    .cosmic-stars {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }
    
    .star {
        position: absolute;
        background: white;
        border-radius: 50%;
        animation: twinkle 2s infinite alternate;
    }
    
    .star:nth-child(1) { width: 2px; height: 2px; top: 20%; left: 20%; animation-delay: 0s; }
    .star:nth-child(2) { width: 1px; height: 1px; top: 80%; left: 80%; animation-delay: 0.5s; }
    .star:nth-child(3) { width: 3px; height: 3px; top: 40%; left: 70%; animation-delay: 1s; }
    .star:nth-child(4) { width: 2px; height: 2px; top: 60%; left: 30%; animation-delay: 1.5s; }
    .star:nth-child(5) { width: 1px; height: 1px; top: 10%; left: 50%; animation-delay: 2s; }
    .star:nth-child(6) { width: 2px; height: 2px; top: 90%; left: 10%; animation-delay: 0.3s; }
    .star:nth-child(7) { width: 1px; height: 1px; top: 30%; left: 90%; animation-delay: 0.8s; }
    .star:nth-child(8) { width: 3px; height: 3px; top: 70%; left: 60%; animation-delay: 1.3s; }
    
    @keyframes twinkle {
        0% { opacity: 0.3; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.2); }
    }
    
    .cosmic-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }
    
    .cosmic-header {
        background: linear-gradient(135deg, 
            rgba(121, 40, 202, 0.2) 0%, 
            rgba(255, 0, 128, 0.15) 50%, 
            rgba(76, 29, 149, 0.2) 100%);
        backdrop-filter: blur(30px);
        border-radius: 30px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .cosmic-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.1), 
            transparent);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .cosmic-title {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e0e7ff, #c7d2fe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
    }
    
    .cosmic-title::before {
        content: "🌌";
        font-size: 2.5rem;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }
    
    .user-cosmic-badge {
        background: linear-gradient(45deg, #7928ca, #ff0080);
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        display: inline-block;
        margin-left: 1rem;
        box-shadow: 
            0 10px 30px rgba(121, 40, 202, 0.4),
            0 0 20px rgba(255, 0, 128, 0.3);
        animation: pulse-cosmic 2s infinite;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    @keyframes pulse-cosmic {
        0% { 
            box-shadow: 
                0 10px 30px rgba(121, 40, 202, 0.4),
                0 0 20px rgba(255, 0, 128, 0.3);
        }
        50% { 
            box-shadow: 
                0 15px 40px rgba(121, 40, 202, 0.6),
                0 0 30px rgba(255, 0, 128, 0.5);
        }
        100% { 
            box-shadow: 
                0 10px 30px rgba(121, 40, 202, 0.4),
                0 0 20px rgba(255, 0, 128, 0.3);
        }
    }
    
    .cosmic-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-cosmic-card {
        background: linear-gradient(135deg, 
            rgba(30, 64, 175, 0.2) 0%, 
            rgba(76, 29, 149, 0.15) 50%, 
            rgba(121, 40, 202, 0.2) 100%);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-cosmic-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #7928ca, #ff0080, #4c1d95);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stat-cosmic-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 
            0 30px 60px rgba(0, 0, 0, 0.3),
            0 0 40px rgba(121, 40, 202, 0.3);
    }
    
    .stat-cosmic-card:hover::before {
        opacity: 1;
    }
    
    .stat-cosmic-number {
        font-size: 2.8rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .stat-cosmic-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
    }
    
    .cosmic-card {
        background: linear-gradient(135deg, 
            rgba(15, 23, 42, 0.8) 0%, 
            rgba(30, 41, 59, 0.6) 50%, 
            rgba(51, 65, 85, 0.8) 100%);
        backdrop-filter: blur(30px);
        border-radius: 30px;
        padding: 2.5rem;
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    
    .cosmic-card::before {
        content: "";
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #7928ca, #ff0080, #4c1d95, #1e40af);
        border-radius: 32px;
        z-index: -1;
        opacity: 0;
        animation: border-glow 3s linear infinite;
    }
    
    @keyframes border-glow {
        0% { opacity: 0; }
        50% { opacity: 0.7; }
        100% { opacity: 0; }
    }
    
    .cosmic-card:hover::before {
        opacity: 0.7;
    }
    
    .create-cosmic-button {
        background: linear-gradient(45deg, #7928ca, #ff0080);
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.4s ease;
        box-shadow: 
            0 10px 30px rgba(121, 40, 202, 0.4),
            0 0 20px rgba(255, 0, 128, 0.3);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .create-cosmic-button:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 
            0 20px 50px rgba(121, 40, 202, 0.6),
            0 0 40px rgba(255, 0, 128, 0.5);
        color: white;
        text-decoration: none;
    }
    
    .create-cosmic-button::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s;
    }
    
    .create-cosmic-button:hover::before {
        left: 100%;
    }
    
    .create-cosmic-button::after {
        content: "✨";
        font-size: 1.2rem;
    }
    
    /* Custom Table Styles */
    .cosmic-table-container {
        background: linear-gradient(135deg, 
            rgba(15, 23, 42, 0.9) 0%, 
            rgba(30, 41, 59, 0.7) 50%, 
            rgba(51, 65, 85, 0.9) 100%);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        padding: 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }
    
    .grid-view table {
        background: transparent !important;
        border: none !important;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .grid-view th {
        background: linear-gradient(135deg, #7928ca, #ff0080, #4c1d95) !important;
        color: white !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        padding: 1.5rem 1rem !important;
        border: none !important;
        position: relative;
        font-size: 0.9rem;
    }
    
    .grid-view th::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0), 
            rgba(255, 255, 255, 0.5), 
            rgba(255, 255, 255, 0));
    }
    
    .grid-view th:first-child {
        border-top-left-radius: 25px;
    }
    
    .grid-view th:last-child {
        border-top-right-radius: 25px;
    }
    
    .grid-view td {
        background: rgba(15, 23, 42, 0.6) !important;
        color: rgba(255, 255, 255, 0.9) !important;
        padding: 1.2rem 1rem !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-left: none !important;
        border-right: none !important;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .grid-view tbody tr:hover td {
        background: linear-gradient(90deg, 
            rgba(121, 40, 202, 0.2), 
            rgba(255, 0, 128, 0.1), 
            rgba(76, 29, 149, 0.2)) !important;
        transform: scale(1.01);
        color: white !important;
    }
    
    .grid-view tbody tr:hover td::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #7928ca, #ff0080);
    }
    
    .grid-view tbody tr:last-child td {
        border-bottom: none !important;
    }
    
    .grid-view tbody tr:last-child td:first-child {
        border-bottom-left-radius: 25px;
    }
    
    .grid-view tbody tr:last-child td:last-child {
        border-bottom-right-radius: 25px;
    }
    
    .cosmic-status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        position: relative;
        overflow: hidden;
    }
    
    .cosmic-status-badge::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: badge-shimmer 2s infinite;
    }
    
    @keyframes badge-shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    .status-new {
        background: linear-gradient(45deg, #10b981, #059669);
        box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
    }
    
    .status-processing {
        background: linear-gradient(45deg, #f59e0b, #d97706);
        box-shadow: 0 5px 20px rgba(245, 158, 11, 0.4);
    }
    
    .status-delivered {
        background: linear-gradient(45deg, #3b82f6, #2563eb);
        box-shadow: 0 5px 20px rgba(59, 130, 246, 0.4);
    }
    
    .status-cancelled {
        background: linear-gradient(45deg, #ef4444, #dc2626);
        box-shadow: 0 5px 20px rgba(239, 68, 68, 0.4);
    }
    
    .cosmic-action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    
    .cosmic-action-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .cosmic-action-btn::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.3s ease;
    }
    
    .cosmic-action-btn:hover::before {
        transform: scale(1.2);
    }
    
    .cosmic-action-btn:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    .btn-view {
        background: linear-gradient(45deg, #3b82f6, #2563eb);
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #f59e0b, #d97706);
    }
    
    .btn-delete {
        background: linear-gradient(45deg, #ef4444, #dc2626);
    }
    
    /* Filter Styles */
    .filters td {
        background: rgba(30, 41, 59, 0.8) !important;
        border-bottom: 2px solid rgba(121, 40, 202, 0.3) !important;
    }
    
    .filters input, .filters select {
        background: rgba(15, 23, 42, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 15px !important;
        padding: 0.7rem !important;
        color: white !important;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .filters input:focus, .filters select:focus {
        background: rgba(30, 41, 59, 0.9) !important;
        box-shadow: 0 0 20px rgba(121, 40, 202, 0.5) !important;
        outline: none !important;
        border-color: #7928ca !important;
    }
    
    .filters input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    
    /* Loading Overlay */
    .cosmic-loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(ellipse at center, rgba(121, 40, 202, 0.9) 0%, rgba(15, 23, 42, 0.95) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(10px);
    }
    
    .cosmic-spinner {
        width: 80px;
        height: 80px;
        border: 3px solid rgba(255, 255, 255, 0.1);
        border-top: 3px solid #7928ca;
        border-right: 3px solid #ff0080;
        border-radius: 50%;
        animation: cosmic-spin 1s linear infinite;
        position: relative;
    }
    
    .cosmic-spinner::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-bottom: 2px solid #4c1d95;
        border-radius: 50%;
        animation: cosmic-spin 0.5s linear infinite reverse;
    }
    
    @keyframes cosmic-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .cosmic-title {
            font-size: 2rem;
        }
        
        .cosmic-container {
            padding: 0 0.5rem;
        }
        
        .cosmic-header, .cosmic-card {
            padding: 1.5rem;
        }
        
        .cosmic-stats {
            grid-template-columns: 1fr;
        }
        
        .grid-view th, .grid-view td {
            padding: 0.8rem 0.5rem !important;
            font-size: 0.8rem;
        }
        
        .cosmic-action-buttons {
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .cosmic-action-btn {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
    }
');

// Enhanced JavaScript for cosmic effects
$this->registerJs('
    // Create cosmic stars
    function createCosmicStars() {
        const starsContainer = $("<div class=\"cosmic-stars\"></div>");
        for (let i = 0; i < 50; i++) {
            const star = $("<div class=\"star\"></div>");
            star.css({
                width: Math.random() * 3 + 1 + "px",
                height: Math.random() * 3 + 1 + "px",
                top: Math.random() * 100 + "%",
                left: Math.random() * 100 + "%",
                animationDelay: Math.random() * 2 + "s"
            });
            starsContainer.append(star);
        }
        $("body").prepend(starsContainer);
    }
    
    // Initialize cosmic effects
    createCosmicStars();
    
    // PJAX loading effects
    $(document).on("pjax:start", function() {
        $("body").append(\'<div class="cosmic-loading"><div class="cosmic-spinner"></div></div>\');
    });
    
    $(document).on("pjax:end", function() {
        $(".cosmic-loading").remove();
        applyCosmicStatusBadges();
    });
    
    // Apply cosmic status badges
    function applyCosmicStatusBadges() {
        $(".grid-view td").each(function() {
            var text = $(this).text().trim().toLowerCase();
            var statusClass = "";
            var statusText = text;
            
            if (text === "новый" || text === "new") {
                statusClass = "status-new";
                statusText = "🆕 " + $(this).text().trim();
            } else if (text === "в обработке" || text === "processing") {
                statusClass = "status-processing";
                statusText = "⚡ " + $(this).text().trim();
            } else if (text === "доставлен" || text === "delivered") {
                statusClass = "status-delivered";
                statusText = "✅ " + $(this).text().trim();
            } else if (text === "отменен" || text === "cancelled") {
                statusClass = "status-cancelled";
                statusText = "❌ " + $(this).text().trim();
            }
            
            if (statusClass) {
                $(this).html(\'<span class="cosmic-status-badge \' + statusClass + \'">\' + statusText + \'</span>\');
            }
        });
    }
    
    // Apply cosmic action buttons
    function applyCosmicActionButtons() {
        $(".grid-view .action-column").each(function() {
            var $cell = $(this);
            var buttons = $cell.find("a");
            var newButtons = $("<div class=\"cosmic-action-buttons\"></div>");
            
            buttons.each(function() {
                var $btn = $(this);
                var href = $btn.attr("href");
                var title = $btn.attr("title");
                var icon = "👁";
                var className = "btn-view";
                
                if (href.includes("update")) {
                    icon = "✏️";
                    className = "btn-edit";
                } else if (href.includes("delete")) {
                    icon = "🗑";
                    className = "btn-delete";
                }
                
                var newBtn = $("<a></a>")
                    .attr("href", href)
                    .attr("title", title)
                    .addClass("cosmic-action-btn " + className)
                    .html(icon);
                
                if ($btn.data("confirm")) {
                    newBtn.attr("data-confirm", $btn.data("confirm"));
                }
                if ($btn.data("method")) {
                    newBtn.attr("data-method", $btn.data("method"));
                }
                
                newButtons.append(newBtn);
            });
            
            $cell.html(newButtons);
        });
    }
    
    // Initialize cosmic effects
    $(document).ready(function() {
        applyCosmicStatusBadges();
        applyCosmicActionButtons();
        
        // Add cosmic glow to price cells
        $(".grid-view td").each(function() {
            var text = $(this).text().trim();
            if (text.includes("₽") || text.includes("RUB")) {
                $(this).css({
                    "color": "#10b981",
                    "font-weight": "700",
                    "text-shadow": "0 0 10px rgba(16, 185, 129, 0.5)"
                });
            }
        });
        
        // Add cosmic glow to ID cells
        $(".grid-view td:first-child").each(function() {
            if ($.isNumeric($(this).text().trim())) {
                $(this).css({
                    "color": "#7928ca",
                    "font-weight": "700",
                    "text-shadow": "0 0 10px rgba(121, 40, 202, 0.5)"
                });
            }
        });
    });
    
    // Enhanced hover effects
    $(".grid-view tbody tr").hover(
        function() {
            $(this).css("transform", "scale(1.01)");
        },
        function() {
            $(this).css("transform", "scale(1)");
        }
    );
');
?>

<div class="order-index">
    <div class="cosmic-container">
        <!-- Cosmic Header -->
        <div class="cosmic-header">
            <h1 class="cosmic-title">
                <?php
                if ($user) {
                    echo Html::encode($this->title);
                    echo '<span class="user-cosmic-badge">' . Html::encode($user->username) . '</span>';
                } else {
                    echo Html::encode($this->title);
                }
                ?>
            </h1>
        </div>

        <!-- Cosmic Statistics -->
        <?php if (!$user): ?>
            <div class="cosmic-stats">
                <div class="stat-cosmic-card">
                    <span class="stat-cosmic-number"><?= $dataProvider->getTotalCount() ?></span>
                    <span class="stat-cosmic-label">Всего заказов</span>
                </div>
                <div class="stat-cosmic-card">
                <span class="stat-cosmic-number">
                    <?php
                    $activeCount = 0;
                    foreach ($dataProvider->models as $model) {
                        if (in_array($model->status, ['новый', 'в обработке', 'new', 'processing'])) {
                            $activeCount++;
                        }
                    }
                    echo $activeCount;
                    ?>
                </span>
                    <span class="stat-cosmic-label">Активных</span>
                </div>
                <div class="stat-cosmic-card">
                <span class="stat-cosmic-number">
                    <?php
                    $totalSum = 0;
                    foreach ($dataProvider->models as $model) {
                        $totalSum += $model->total_price;
                    }
                    echo number_format($totalSum, 0, ',', ' ') . ' ₽';
                    ?>
                </span>
                    <span class="stat-cosmic-label">Общая сумма</span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Cosmic Main Card -->
        <div class="cosmic-card">
            <?php if (!$user): ?>
                <div style="margin-bottom: 2rem;">
                    <?= Html::a('Создать заказ', ['create'], ['class' => 'create-cosmic-button']) ?>
                </div>
            <?php endif; ?>

            <?php Pjax::begin(['id' => 'orders-pjax', 'enablePushState' => false]); ?>

            <div class="cosmic-table-container">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table'],
                    'headerRowOptions' => ['class' => 'cosmic-header-row'],
                    'filterRowOptions' => ['class' => 'filters'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width: 60px; text-align: center;'],
                        ],
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width: 80px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                        ],
                        [
                            'attribute' => 'user_id',
                            'headerOptions' => ['style' => 'width: 150px;'],
                            'value' => function($model) {
                                return $model->user ? $model->user->username : 'ID: ' . $model->user_id;
                            },
                        ],
                        [
                            'attribute' => 'total_price',
                            'format' => ['currency', 'RUB'],
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                        ],
                        [
                            'attribute' => 'status',
                            'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'filter' => [
                                'новый' => 'Новый',
                                'в обработке' => 'В обработке',
                                'доставлен' => 'Доставлен',
                                'отменен' => 'Отменен',
                            ],
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => ['datetime', 'php:d.m.Y H:i'],
                            'headerOptions' => ['style' => 'width: 150px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                        ],
                        [
                            'class' => ActionColumn::class,
                            'header' => 'Действия',
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'contentOptions' => ['class' => 'action-column', 'style' => 'text-align: center;'],
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('👁', $url, [
                                        'title' => 'Просмотр',
                                        'class' => 'cosmic-action-btn btn-view',
                                    ]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('✏️', $url, [
                                        'title' => 'Редактировать',
                                        'class' => 'cosmic-action-btn btn-edit',
                                    ]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('🗑', $url, [
                                        'title' => 'Удалить',
                                        'class' => 'cosmic-action-btn btn-delete',
                                        'data' => [
                                            'confirm' => 'Вы уверены, что хотите удалить этот заказ?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>