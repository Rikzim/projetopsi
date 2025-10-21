# setup.ps1
Write-Host "=== Instalação automática Yii2 Advanced ===`n"

# 1. Instalar dependências
composer install

# 2. Inicializar aplicação (Development)
php init --env=Development --overwrite=All --delete=All --interactive=0

# 3. Mudar o nome da base de dados
$configFile = "common/config/main-local.php"
Write-Host "`nA configurar base de dados no ficheiro: $configFile"
(Get-Content $configFile) -replace "'dbname' => '.*?'," , "'dbname' => 'lusitania_teste'," | Set-Content $configFile -Encoding UTF8

# 4. Executar migrações
php yii migrate --interactive=0

# 5. Instalar o SwiftMailer
composer require yiisoft/yii2-swiftmailer

Write-Host "`n=== Configuração concluída ==="
