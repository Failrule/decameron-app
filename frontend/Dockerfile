# Usa la imagen base de Node.js
FROM node:latest

# Establece el directorio de trabajo
WORKDIR /app

# Copia el package.json y el package-lock.json
COPY ./app/package*.json /app

# Instala las dependencias
RUN npm install

# Comando para iniciar la aplicación
CMD ["npm", "start"]
