#!/bin/bash

# ===========================================
# DEPLOYMENT SCRIPT - SMKN3 Malang e-Skill Lib
# ===========================================
# Jalankan script ini di VPS:
# cd ~/proyek-smkn3malang && bash deploy.sh
# ===========================================

set -e

echo "=========================================="
echo "  SMKN3 Malang e-Skill Lib Deployment"
echo "=========================================="

# Variables
DB_USER="root"
DB_PASS="Abogoboga@123"
DB_NAME="smkn3malang_db"
DOCKER_IMAGE="raflyherdianto25/smkn3malang-app"
PROJECT_DIR="/home/rafly/proyek-smkn3malang"
BACKUP_DIR="/home/rafly/backups/$(date +%Y%m%d_%H%M%S)"
VOLUME_NAME="proyek-smkn3malang_laravel_storage"

# Change to project directory
cd $PROJECT_DIR

# Create backup directory
mkdir -p $BACKUP_DIR

echo ""
echo "[1/8] Backing up database..."
docker exec mysql mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/database.sql
echo "      Database backed up to: $BACKUP_DIR/database.sql"

echo ""
echo "[2/8] Backing up storage volume..."
docker run --rm \
    -v ${VOLUME_NAME}:/data:ro \
    -v $BACKUP_DIR:/backup \
    alpine tar cvf /backup/storage.tar /data > /dev/null 2>&1
echo "      Storage backed up to: $BACKUP_DIR/storage.tar"

echo ""
echo "[3/8] Tagging current image as backup..."
docker tag $DOCKER_IMAGE:latest $DOCKER_IMAGE:v1.0-backup 2>/dev/null || echo "      Image already tagged or not found locally"

echo ""
echo "[4/8] Stopping and renaming current container..."
if docker ps -a --format '{{.Names}}' | grep -q "^smkn3malang-web$"; then
    docker stop smkn3malang-web
    docker rename smkn3malang-web smkn3malang-web-old
    docker start smkn3malang-web-old
    echo "      Container renamed to: smkn3malang-web-old"
else
    echo "      Container smkn3malang-web not found, skipping rename"
fi

echo ""
echo "[5/8] Pulling latest image..."
docker pull $DOCKER_IMAGE:latest

echo ""
echo "[6/8] Starting new container..."
docker run -d \
    --name smkn3malang-web \
    --restart unless-stopped \
    --network shared-network \
    -v ${PROJECT_DIR}/.env:/var/www/html/.env:ro \
    -v ${VOLUME_NAME}:/var/www/html/storage/app/public \
    $DOCKER_IMAGE:latest

echo ""
echo "[7/8] Running database migrations..."
sleep 5  # Wait for container to be ready
docker exec smkn3malang-web php artisan migrate --force

echo ""
echo "[8/8] Running seeders for new data..."
docker exec smkn3malang-web php artisan db:seed --class=SubJurusanSeeder --force

echo ""
echo "=========================================="
echo "  DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Configure Nginx Proxy Manager:"
echo "   - eskill-lib.web.id      -> smkn3malang-web:80"
echo "   - old.eskill-lib.web.id  -> smkn3malang-web-old:80"
echo ""
echo "2. Verify both containers are running:"
echo "   docker ps | grep smkn3malang"
echo ""
echo "3. Check logs if needed:"
echo "   docker logs smkn3malang-web"
echo "   docker logs smkn3malang-web-old"
echo ""
echo "Backup location: $BACKUP_DIR"
echo "=========================================="
