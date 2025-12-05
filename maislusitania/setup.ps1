# setup.ps1
Write-Host "=== Instalaçao automatica Yii2 Advanced ===`n"

# 1. Instalar dependências
composer install

# Criar pastas necessárias  
$folders = @(
    "backend/web/assets",
    "frontend/web/assets",
    "backend/runtime",
    "frontend/runtime",
    "console/runtime"
)

# Verifica se as pastas necessárias existem e garante que as pastas de assets e runtime estão preparadas antes da execução do projeto.
foreach ($folder in $folders) {
    if (-Not (Test-Path $folder)) {
        New-Item -ItemType Directory -Force -Path $folder | Out-Null
    }
}


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

Write-Host "`n=== Configuracao concluida ==="
