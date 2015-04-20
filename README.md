# iUsuarios Modulo de Gestión de Usuarios.

Un sistema que involucra a todo o gran parte del personal, requiere de un control estricto de a qué información se quiere dar 
acceso y cuál es el grado de permisos que queremos asignar a cada empleado. Al definir la organización como una estructura 
jerárquica, se puede definir qué parte de la jerarquía puede visualizar un empleado, permitiendo al mismo que descienda en la 
jerarquía hasta el nivel deseado, pero que no pueda ascender por la misma, más allá de lo que se le ha autorizado. Diferentes 
roles permiten asignar a cada usuario que pueden hacer con la información, sólo consultarla, darla de alta o modificarla, 
visualizar los datos de carácter personal o que éstos permanezcan ocultos. Cada rol está formado por un conjunto de acciones 
que se pueden personalizar, variando los tipos de acciones que puede realizar cada uno.

Insside® Permite organizar, distribuir y clasificar los privilegios que se pueden otorgar a los usuarios del sistema. 
Conceptualmente se ha desarrollado un módulo intuitivo y altamente efectivo para gestionar las diversas aplicaciones creadas 
en la plataforma. Este módulo es genérico y sufre actualizaciones de seguridad periódicas que se propagan a los aplicativos 
creados por Insside® sin sobrecostos adicionales para los clientes. El IMIS como todas aplicaciones creadas mediante la 
plataforma Insside® fundamenta el acceso al sistema en el concepto de “Privilegios & Restricciones”, donde los permisos se 
definen en la programación de los módulos y su utilización se convierte en un elemento escalable mediante la asignación de los 
mismos a roles en el sistema, los cuales consecuentemente serán desempeñados por múltiples usuarios. A continuación procederemos 
a definir formalmente los elementos conceptuales del módulo.

Permisos: Uno de los aspectos que suelen causar confusión entre los usuarios de prácticamente, cualquier tipo de sistema 
informático son los permisos, en nuestra plataforma un permiso es una propiedad que tiene o no tiene el rol que desempeña un 
usuario, mediante esta propiedad se garantiza el acceso a la utilización de un determinado recurso o función efectuada por un 
módulo y/o sus componentes, la existencia del permiso en instancia garantiza el acceso, su ausencia niega la utilización o 
acceso a cualquier funcionalidad otorgada por el mismo tanto a nivel de interface como a nivel operativo “Acceso Denegado”.
Roles: Todos los usuarios están sujetos a las reglas de permisos a la hora de trabajar en un sistema informático. Un Rol 
agrupa una serie de permisos que en esencia definen las funciones de un usuario en el sistema, esta política es utilizada 
generalmente para poder rotar la funciones informáticas y reales de un empleado de la empresa u entidad en la medida que 
este desempeña diferentes cargos reales en la misma, o incluso poder asignar sus funciones a quien lo remplaza al momento 
de la rotación de los cargos, periodo vacaciones y similares.

Usuario: En términos generales, un usuario es un conjunto de permisos asignados mediante roles a los cuales tiene acceso una entidad (Es decir, un usuario puede ser tanto una persona como una máquina, un programa, etc.) cuyas funciones en el sistema están determinadas por el rol o roles que desempeña, su identidad es única y generalmente está asociada al perfil de un empleado. Una vez este usuario a interactuado con el sistema realizando modificaciones y similares no podrá ser eliminado ya que afectaría la integridad referencial de la información. Pero sus privilegios podrán ser reasignados libremente como y cuando se requiera sin consecuencias colaterales, mas halla de la finalización de sus funciones.
Instrucciones de Utilización
.
Los vinculos que se listan a continuación tienen por objetivo brindar una herramienta de guía a los usuarios de las diferentes areas en el manejo de los procesos que conforman el Aplicativo IMIS.
