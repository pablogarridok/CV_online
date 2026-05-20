pipeline {
    agent any

    environment {
        PI_USER    = 'pi'
        PI_HOST    = 'host.docker.internal'
        DEPLOY_DIR = '/var/www/html/cv_site'
        SSH_KEY    = '/var/jenkins_home/.ssh/id_ed25519'
        SSH_OPTS   = '-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null'
    }

    stages {

        stage('Descargar código') {
            steps {
                checkout scm
                echo 'Código descargado de GitHub correctamente'
            }
        }

        stage('Validar PHP') {
            steps {
                sh """
                    # Copiar ficheros al host para poder validarlos con PHP
                    scp -i ${SSH_KEY} ${SSH_OPTS} -r backend/ ${PI_USER}@${PI_HOST}:/tmp/cv_deploy/

                    # Ejecutar php -l en cada fichero .php del host
                    ssh -i ${SSH_KEY} ${SSH_OPTS} ${PI_USER}@${PI_HOST} \
                        'find /tmp/cv_deploy -name "*.php" -exec php -l {} \\; && echo "Todos los ficheros PHP son válidos"'
                """
            }
        }

        stage('Desplegar en Apache') {
            steps {
                sh """
                    ssh -i ${SSH_KEY} ${SSH_OPTS} ${PI_USER}@${PI_HOST} '
                        sudo rm -rf ${DEPLOY_DIR} &&
                        sudo mv /tmp/cv_deploy ${DEPLOY_DIR} &&
                        sudo chown -R www-data:www-data ${DEPLOY_DIR} &&
                        sudo chmod -R 755 ${DEPLOY_DIR} &&
                        sudo systemctl reload apache2 &&
                        echo "Despliegue completado en Apache"
                    '
                """
            }
        }

    }

    post {
        success {
            echo 'Pipeline completado con éxito. CV actualizado y accesible.'
        }
        failure {
            sh """
                ssh -i ${SSH_KEY} ${SSH_OPTS} ${PI_USER}@${PI_HOST} \
                    'rm -rf /tmp/cv_deploy' || true
            """
            echo 'El pipeline ha fallado. Revisa los logs para ver el error.'
        }
    }
}
