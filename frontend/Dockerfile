# Utilizar una imagen base de Node
FROM node:14

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar el archivo package.json y package-lock.json
#COPY package*.json ./

# Instalar las dependencias de la aplicación
RUN npm i

# Copiar el resto de la aplicación
#COPY . .

# Exponer el puerto
EXPOSE 3000

# Iniciar la aplicación
CMD ["npm", "start"]